library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)

##########################################################
## Create Random Data for Shelter Animals SQL Table ##
##########################################################

# The shelter animals table includes information about animals located at kill shelters. These require movement
# depending on duration and time at the shelter.The actual dates will likely need to be changed. 

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'
sh <- read.csv(paste(path,'Data/shelters_data.csv',sep=''))
sh <- sh[sh$euthStatus=='euthanasia',]

# Define features
features <- c('shelterAnimalId','species','shelterId','arrivalDate','euthDate','daysToEuth')

# applicationId
shelterAnimalId <- paste('SA',1000:1249,sep='')
shelter_animals <- data.frame(shelterAnimalId)

# species
sp <- c('dog','cat')
shelter_animals$species <- sample(sp,nrow(shelter_animals),replace = TRUE,prob = c(1/3,2/3))

# shelterId
shs <- sample(sh$shelterId,nrow(shelter_animals),replace = TRUE)
shelter_animals$shelterId <- shs

# arrivalDate, euthDate, daysToEuth
d <- sh[,c('shelterId','euthDuration')]
d$euthDuration <- as.numeric(as.character(d$euthDuration))
shelter_animals <- merge(shelter_animals,d,by='shelterId')
shelter_animals <- shelter_animals[order(shelter_animals$shelterAnimalId),]

today <- as.Date('2019/05/01')
shelter_animals$euthDate <- today
shelter_animals$arrivalDate <- today

for (animal in (1:nrow(shelter_animals))) {
  euthD <- shelter_animals$euthDuration[animal]
  x <- sample(seq(1, euthD, 1),1,replace=TRUE)
  ad <- today - as.difftime(x, unit="days")
  shelter_animals$arrivalDate[animal] <- ad
  shelter_animals$euthDate[animal] <- ad + as.difftime(euthD, unit='days')
  shelter_animals$daysToEuth[animal] <- euthD-x  
}

# Reorder and remove unnecessary columns
shelter_animals <- shelter_animals[order(shelter_animals$shelterAnimalId),features]

# Write to csv
write.csv(shelter_animals,file='Data/shelter_animals_data.csv',row.names = FALSE)
