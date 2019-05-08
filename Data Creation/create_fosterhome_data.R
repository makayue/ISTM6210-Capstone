library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)

##########################################################
## Create Random Data for Foster Homes SQL Table ##
##########################################################

# The foster homes table includes information about the homes of registered fosters and foster applicants. 

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'

regfos <- read.csv(paste(path,'Data/registered_fosters.csv',sep=''))
regfos <- setNames(as.data.frame(regfos[,'fosterId']), 'fosterId')
fosapp <- read.csv(paste(path,'Data/foster_applicants.csv',sep=''))
fosapp <- setNames(as.data.frame(fosapp[,'fosterId']), 'fosterId')
allfos <- rbind(regfos,fosapp)

features <- c('homeId','homeType','fencedBackyard','homeOwnership','residents','pets','petsVaccinated','fosterId')

# homeId
homeId <- paste('FH',1000:(999+nrow(allfos)),sep = '')
foster_homes <- data.frame(homeId)

# homeType
types <- c('house','apartment or condo')
foster_homes$homeType <- sample(types,
                                nrow(foster_homes),
                                replace = TRUE,
                                prob = c(3/5,2/5))

# fencedBackyard
yn <- c('yes','no')
foster_homes$fencedBackyard <- ifelse(foster_homes$homeType == 'house', 
                                      sample(yn,nrow(foster_homes),
                                             replace = TRUE,
                                             prob = c(2/3,1/3)), 'no')

# homeOwnership
foster_homes$homeOwnership <- sample(yn,nrow(foster_homes),
                                     replace = TRUE,
                                     prob = c(2/5,3/5))

# residents
foster_homes$residents <- sample(seq(1,6,1),
                                 nrow(foster_homes),
                                 replace = TRUE,
                                 prob = c(3/12,4/12,2/12,1/12,1/12,1/12))

# pets
foster_homes$pets <- sample(seq(0,4,1),
                            nrow(foster_homes),
                            replace = TRUE,
                            prob = c(3/10,3/10,2/10,1/10,1/10))

# petsVaccinated
foster_homes$petsVaccinated <- ifelse(foster_homes$pets > 0, 
                                      sample(yn,nrow(foster_homes),
                                             replace = TRUE,
                                             prob = c(4/5,1/5)),'not applicable')


# fosterId
foster_homes$fosterId <- allfos$fosterId

# Ensure correct order and write to csv
foster_homes <- foster_homes[features]
write.csv(foster_homes,file='Data/fosterhomes_data.csv',row.names = FALSE)
