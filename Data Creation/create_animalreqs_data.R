library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)

##########################################################
## Create Random Data for Home Requirements SQL Table ##
##########################################################

# The home requirements table includes information about the home requirements for animals registered in the system
# that are either being fostered currently or ready to be fostered. Shelter_Animals are not included as they have
# not been brought to a no-kill shelter. 

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'
animals <- read.csv(paste(path,'Data/animal_data.csv',sep=''))

# Define features
features <- c('homeReqId','homeType','fencedBackyard','homePrefWithMen','homePrefWithWomen','homePrefWithChildren',
              'homePrefWithPets','animalId')

# homeReqId
homeReqId <- setNames(as.data.frame(paste('HR',1000:1799,sep='')), c('homeReqId'))

home_reqs <- merge(homeReqId,animals,by = 'row.names')


# homeType
types <- c('house','apartment or condo','any')
home_reqs$homeType <- ifelse(home_reqs$species=='dog' & home_reqs$size == 'large', 'house',
                             ifelse((home_reqs$species=='dog' & home_reqs$size != 'large'),
                                    sample(types,nrow(home_reqs),replace = TRUE), 'any'))

# fencedBackyard
home_reqs$fencedBackyard <- ifelse(home_reqs$homeType == 'house', 'yes','no')


# homePrefWithMen
hp <- c('yes','no')
home_reqs$homePrefWithMen <- sample(hp,nrow(home_reqs),replace = TRUE,prob = c(3/4,1/4))

# homePrefWithWomen
home_reqs$homePrefWithWomen <- sample(hp,nrow(home_reqs),replace = TRUE,prob = c(4/5,1/5))

# homePrefWithChildren
home_reqs$homePrefWithChildren <- sample(hp,nrow(home_reqs),replace = TRUE,prob = c(3/5,2/5))

# homePrefWithPets
home_reqs$homePrefWithPets <- sample(hp,nrow(home_reqs),replace = TRUE,prob = c(1/2,1/2))

# Save only needed columns and write to csv.
home_reqs <- home_reqs[order(home_reqs$homeReqId),features]
write.csv(home_reqs,file='Data/homereq_data.csv',row.names = FALSE)
