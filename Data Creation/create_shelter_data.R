library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)

#########################################################
## Create Random Data for Shelters SQL Table ##
#########################################################

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'

set.seed(567)

# Define features
features <- c('shelterId','shelterName','shelterAddress','shelterCity','shelterState','shelterZipCode',
              'shelterPhoneNumber','euthStatus','euthDuration')

# shelterId
shelterId <- paste('SH',1000:1023,sep = '')
shelters <- data.frame(shelterId)

## Shelter Names ##
# Good Shelters
sh <- setNames(as.data.frame(c('Your Neighborhood Animal Rescue','Fluffy Tails Animal Shelter','Arlington Shelter', 'NOVA Animal Shelter', 
        'Kennel Resist Rescue','Paws Patrol Animal Rescue','Puppy Noses and Kitty Tails Rescue', 
        'No Ruff Days Animal Rescue', 'Paws and Claws Rescue','Just A Little Husky Animal Shelter', 
        'Round of A-PAWS Rescue', 'Four Paws Up Animal Rescue')), 'shelterName')
sh$euthStatus <- 'no euthanasia'
sh$euthDuration <- 'not applicable'

# Bad Shelters
bsh <- setNames(as.data.frame(c('NOVA Animal Pound','Arlington Pound','Animal Shelter','We Got Pets','No-Good Animal Shelter','No Bueno Shelter',
         'Generic Animal Shelter','Just a Shelter','The Animal Pound','ABC Shelter','Shelter 123','Just Animals Shelter')),'shelterName')
bsh$euthStatus <- 'euthanasia'
bsh$euthDuration <- sample(seq(3,14,1),nrow(bsh),replace=TRUE)
shelter_names <- rbind(sh,bsh)
shelters <- merge(shelters,shelter_names,by='row.names')

# Shelter Address
addr <- read.csv(paste(path,'shelter_addresses.csv',sep=''),header=TRUE)
shelters <- merge(shelters,addr,by='row.names')
shelters <- subset(shelters, select=!(colnames(shelters) %in% c('Row.names')))

# Shelter Phone Number
shelters$shelterPhoneNumber <- r_phone_numbers(24, use_hyphens = TRUE)

# Reorder
shelters <- shelters[order(shelters$shelterId),features]

# Write to csv
write.csv(shelters, file='Data/shelters_data.csv',row.names = FALSE)
