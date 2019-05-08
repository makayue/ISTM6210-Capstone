library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)
library(tidyverse)
library(lubridate)

##########################################################
## Create Random Data for Animal Request SQL Table ##
##########################################################

# The animal request table includes information related to the transaction to request to foster an animal. 

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'

# Define features
features <- c('requestId','requestDate','fosterId','animalId','requestStatus')

# Get fosterIds from registered_fosters and availability from foster_preference tables. 
fosters <- read.csv(paste(path,'Data/registered_fosters.csv',sep=''))
prefs <- read.csv(paste(path,'Data/fosterpref_data.csv',sep=''))
fp <- merge(fosters,prefs,by='fosterId')
fp <- fp[fp$availableNow == 'yes',c('fosterId','fosterActivity','species','animalCount','specialNeeds')]


# Get animalId and fosterStatus from animals table
animals <- read.csv(paste(path,'Data/animal_data.csv',sep=''))


# fosterId
# Combine Active Fosters with animals located in foster homes

# Break up active fosters by species
active_fosters <- fp[fp$fosterActivity=='Active Foster',]
active_cat_fosters <- active_fosters[active_fosters$species =='cat',]
active_dog_fosters <- active_fosters[active_fosters$species =='dog',]
active_any_fosters <- active_fosters[active_fosters$species =='any',]

# Select animals currently being fostered
active_animals <- animals[animals$location =='foster home',]
active_cats <- active_animals[active_animals$species=='cat',]
active_dogs <- active_animals[active_animals$species=='dog',]

# Match Special Needs
sn_cat_fosters <- active_cat_fosters[active_cat_fosters$specialNeeds=='yes',]
sn_dog_fosters <- active_dog_fosters[active_dog_fosters$specialNeeds=='yes',]
sn_cats <- active_cats[active_cats$specialNeeds!='no',] 
sn_dogs <- active_dogs[active_dogs$specialNeeds!='no',]
# SN Cats
matched_fosters <- sn_cat_fosters[1:nrow(sn_cats),]
matched_fosters$animalId <- sn_cats$animalId
# SN Dogs
matched_SN_dogs <- sn_dog_fosters[1:nrow(sn_dogs),]
matched_SN_dogs$animalId <- sn_dogs$animalId
matched_fosters <- rbind(matched_fosters,matched_SN_dogs)

# Remove cat from active_cats
active_cats <- active_cats[!(active_cats$animalId %in% matched_fosters$animalId),]
sn_cats <- sn_cats[!(sn_cats$animalId %in% matched_fosters$animalId),]

# Remove dogs from active_dogs
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]
sn_dogs <- sn_dogs[!(sn_dogs$animalId %in% matched_fosters$animalId),]

# Update active_cat_fosters and active_dog_fosters if the animalCount is <2
for (f in 1:nrow(matched_fosters)) {
  if (matched_fosters$animalCount[f] <2) {
    active_cat_fosters <- active_cat_fosters[!(active_cat_fosters$fosterId %in% matched_fosters$fosterId[f]),]
  }
}
  
# Cats that must be alone
single_cats <- active_cats[active_cats$goodWithCats == 'no' & active_cats$goodWithDogs == 'no',('animalId')]
active_cat_fosters_1 <- active_cat_fosters[active_cat_fosters$animalCount<2,]

if (length(single_cats) < length(active_cat_fosters_1)) {
  matched_single_cat_fosters <- active_cat_fosters_1[1:length(single_cats),]
  matched_single_cat_fosters$animalId <- single_cats ## Placed foster with pet
  
  # Update matched_fosters
  matched_fosters <- rbind(matched_fosters,matched_single_cat_fosters)
  active_cats <- active_cats[!(active_cats$animalId %in% matched_fosters$animalId),]
  
  # Place remaining single cat fosters after single cats placed
  active_cat_fosters_1$animalId <- active_cats[1:nrow(active_cat_fosters_1),'animalId']
  matched_fosters <- rbind(matched_fosters,active_cat_fosters_1)
  
} else {
  matched_single_cat_fosters <- active_cat_fosters_1[1:length(active_cat_fosters_1)]
  matched_single_cat_fosters$animalId <- single_cats[1:nrow(matched_single_cat_fosters)]
  
  # Update matched_fosters, single cats, and cat fosters
  matched_fosters <- rbind(matched_fosters,matched_single_cat_fosters)
  single_cats <- single_cats[!(single_cats %in% matched_fosters$animalId)]
  active_cat_fosters_1 <- active_cat_fosters_1[!(active_cat_fosters_1$fosterId %in% matched_fosters$fosterId),]
  active_cat_fosters <- active_cat_fosters[!(active_cat_fosters$fosterId %in% matched_fosters$fosterId),]
  
  # Place remaining single cats with cat fosters with 2+ animal count  
  active_cat_fosters_2 <- active_cat_fosters[active_cat_fosters$animalCount > 2,]
  active_cat_fosters_2 <- active_cat_fosters[1:length(single_cats),]
  active_cat_fosters_2$animalId <- single_cats
  matched_fosters <- rbind(matched_fosters,active_cat_fosters_2)
}

# Update cats that need fostering
single_cats <- single_cats[!(single_cats %in% matched_fosters$animalId)]                               
active_cats <- active_cats[!(active_cats$animalId %in% matched_fosters$animalId),]

# Place cats with remaining cat fosters without any cats
active_cat_fosters_singles <- active_cat_fosters[!(active_cat_fosters$fosterId %in% matched_fosters$fosterId),]
active_cat_fosters_singles$animalId <- active_cats$animalId[1:nrow(active_cat_fosters_singles)]
matched_fosters <- rbind(matched_fosters,active_cat_fosters_singles)
active_cats <- active_cats[!(active_cats$animalId %in% matched_fosters$animalId),]

# Place remaining cats with fosters who selected "any" as a species preference
active_any_cats <- active_any_fosters[1:nrow(active_cats),]
active_any_cats$animalId <- active_cats$animalId
matched_fosters <- rbind(matched_fosters,active_any_cats)

# Update active cats and active_any_fosters
active_cats <- active_cats[!(active_cats$animalId %in% matched_fosters$animalId),]
for (foster in 1:nrow(matched_fosters)) {
  if (matched_fosters$species[foster] == 'any' & matched_fosters$animalCount[foster] == 1) {
    active_any_fosters <- active_any_fosters[!(active_any_fosters$fosterId %in% matched_fosters$fosterId),]
  }
}

# Dogs that must be alone
single_dogs <- active_dogs[active_dogs$goodWithCats == 'no' & active_dogs$goodWithDogs == 'no',('animalId')]
active_dog_fosters_1 <- active_dog_fosters[active_dog_fosters$animalCount<2,]
active_dog_fosters_1$animalId <- single_dogs[1:nrow(active_dog_fosters_1)]
matched_fosters <- rbind(matched_fosters,active_dog_fosters_1)

# Update remaining single dogs and fosters
single_dogs <- single_dogs[nrow(active_dog_fosters_1):length(single_dogs)]
active_dog_fosters <- active_dog_fosters[!(active_dog_fosters$fosterId %in% active_dog_fosters_1$fosterId),]
active_dog_fosters_2 <- active_dog_fosters[1:length(single_dogs),]
active_dog_fosters_2$animalId <- single_dogs
matched_fosters <- rbind(matched_fosters,active_dog_fosters_2)
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]
active_dog_fosters <- active_dog_fosters[!(active_dog_fosters$fosterId %in% matched_fosters$fosterId),]

# Place dogs with remaining fosters
active_dog_fosters$animalId <- active_dogs$animalId[1:nrow(active_dog_fosters)]
matched_fosters <- rbind(matched_fosters,active_dog_fosters)
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]
#active_dog_fosters <- active_dog_fosters[!(active_dog_fosters$fosterId %in% matched_fosters$fosterId),]

# Place dogs with any fosters
not_good_with_dogs <- active_dogs[active_dogs$goodWithDogs=='no','animalId']
active_any_fosters$animalId <- not_good_with_dogs[1:nrow(active_any_fosters)]
matched_fosters <- rbind(matched_fosters,active_any_fosters)
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]

# Update any fosters to only include those with animal counts > 1
active_any_fosters <- active_any_fosters[active_any_fosters$animalCount > 1,]

# Place remaining dogs
aaf_1 <- active_any_fosters
aaf_1$animalId <- active_dogs[1:nrow(aaf_1),'animalId']
matched_fosters <- rbind(matched_fosters,aaf_1)
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]
adf_1 <- active_dog_fosters
adf_1$animalId <- active_dogs$animalId[1:nrow(adf_1)]
matched_fosters <- rbind(matched_fosters,adf_1)
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]
aaf_2 <- active_any_fosters[active_any_fosters$animalCount>2,]
aaf_2$animalId <- active_dogs$animalId[1:nrow(aaf_2)]
matched_fosters <- rbind(matched_fosters,aaf_2)
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]
active_dog_fosters <- active_dog_fosters[active_dog_fosters$animalCount>2,]
active_dog_fosters$animalId <- active_dogs$animalId[1:nrow(active_dog_fosters)]
matched_fosters <- rbind(matched_fosters,active_dog_fosters)
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]
active_dog_fosters <- active_dog_fosters[active_dog_fosters$animalCount>3,]
active_dog_fosters$animalId <- active_dogs$animalId[1:nrow(active_dog_fosters)]
matched_fosters <- rbind(matched_fosters,active_dog_fosters)
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]
active_dog_fosters <- active_dog_fosters[active_dog_fosters$animalCount>4,]
active_dog_fosters$animalId <- active_dogs$animalId[1:nrow(active_dog_fosters)]
matched_fosters <- rbind(matched_fosters,active_dog_fosters)
active_dogs <- active_dogs[!(active_dogs$animalId %in% matched_fosters$animalId),]
# Ensure all fosters and all fostered animals are being placed
#active_fosters <- fp[fp$fosterActivity=='Active Foster',]
#active_fosters$fosterId %in% matched_fosters$fosterId
#matched_fosters$fosterId %in% active_fosters$fosterId
#active_animals$animalId %in% matched_fosters$animalId

# add to animal_request table
animal_request <- matched_fosters[,c('fosterId','animalId')]
animal_request$requestStatus <- 'Approved'

# find remaining fosters
rem_fosters <- fp[!(fp$fosterId %in% animal_request$fosterId),]
rem_animals <- animals[animals$fosterStatus == 'Pending',]

# Pending can either be awaiting animal request approval or in-process registration. 

#################################RIGHT HERE###############################
# differentiate between special needs and no special needs 
rem_animals_nsn <- rem_animals[rem_animals$specialNeeds == 'no',]
rem_fosters$animalId <- rem_animals_nsn$animalId[1:nrow(rem_fosters)]
rs <- c('Submitted','Under Review','Request for more information')
rem_fosters$requestStatus <- sample(rs,nrow(rem_fosters),replace = TRUE)
animal_request <- rbind(animal_request,rem_fosters[,c('fosterId','animalId','requestStatus')])

# check to ensure all fosters are located in final animal_request table
#fp$fosterId %in% animal_request$fosterId
#animal_request$fosterId %in% animal_request$fosterId

# requestId -- can do this after the fosters are all placed and such
animal_request$requestId <- paste('AR',1000:(999+nrow(animal_request)),sep = '')

# requestDate
# require registration date to ensure request falls after 
animal_request_rd <- merge(animal_request,animals,by='animalId')
animal_request_rd$requestDate <- as.Date('2019/05/01')

for (animal in (1:nrow(animal_request_rd))) {
  date <- sample(seq(as.Date(animal_request_rd$registrationDate[animal]), as.Date('2019/05/01'), by='day'),1,replace = TRUE)
  animal_request_rd$requestDate[animal] <- date
}

# Join new requestDate data with animal_request table
armerge <- animal_request_rd[,c('fosterId','animalId','requestDate')]
animal_request <- merge(animal_request,armerge,by=c('fosterId','animalId'))

# Ensure right columns and order
animal_request <- animal_request[order(animal_request$requestId),features]

# Write to CSV
write.csv(animal_request,file=paste(path,'Data/animalrequest_data.csv',sep = ''),row.names = FALSE)


