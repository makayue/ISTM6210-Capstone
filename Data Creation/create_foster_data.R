library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)

#########################################################
## Create Random Data for Registered_Fosters SQL Table ##
#########################################################

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'

set.seed(123)

# Define features
features <- c('fosterId','lastName','firstName','emailAddress','gender','userAddress','userCity','userState',
              'userZipCode','phone','birthDate','employmentStatus','fosterActivity','specialNeedsExp','hoursAway',
              'applicationId')

# fosterId
fosterId <- paste('FO',1000:1349,sep='')
registered_fosters <- data.frame(fosterId)

# Female Fosters
lng <- 1/2*nrow(registered_fosters)
n <- setNames(as.data.frame(randomNames(lng,gender = 1)), c('name'))
n_split <- separate(n,name,c('lastName','firstName'),sep = ', ', remove = TRUE)
n_split$gender <- 'female'

# Male Fosters
mn <- setNames(as.data.frame(randomNames(lng,gender = 2)), c('name'))
mn_split <- separate(mn,name,c('lastName','firstName'),sep = ', ', remove = TRUE)
mn_split$gender <- 'male'

n_total <- rbind(n_split,mn_split)
n_total <- n_total[sample(nrow(n_total)),]

# Add foster names
registered_fosters <- merge(registered_fosters,n_total,by='row.names')

# emailAddress
dom <- c('yahoo.com','gmail.com','aol.com','msn.com')
for (r in registered_fosters) {
  registered_fosters$emailAddress <- paste(registered_fosters$lastName,
                                           substr(registered_fosters$firstName,1,1),'@',
                                           sample(dom,replace = TRUE),sep='')
}

# userAddress, userCity, userState, userZipCode
addr <- read.csv(paste(path,'registered_fosters_addresses.csv',sep=''),header=TRUE)
addr <- rbind(addr,addr,addr)
registered_fosters <- merge(registered_fosters,addr,by='row.names',all.x = TRUE)

# Phone
registered_fosters$phone <- r_phone_numbers(nrow(registered_fosters), use_hyphens = TRUE)

# Birthdate
bd <- sample(seq(as.Date('1947/01/01'), as.Date('2011/12/31'), by='day'),
             nrow(registered_fosters),replace = TRUE)
registered_fosters$birthDate <- bd

# Employment Status
es <- c('Employed','Unemployed','Student','Retired')
registered_fosters$employmentStatus <- sample(es,nrow(registered_fosters),
                                              replace=TRUE,prob = c(1/2,20/200,40/200,40/200))

# FosterActivity
av <- c('Inactive Foster','Active Foster')
registered_fosters$fosterActivity <- sample(av, 
                                        nrow(registered_fosters), 
                                        prob = c(90/200,110/200), 
                                        replace=TRUE)

# specialNeedsExp
yn <- c('yes','no')
registered_fosters$specialNeedsExp <- sample(yn,
                                             nrow(registered_fosters),
                                             prob = c(1/4,3/4),
                                             replace = TRUE)

# Hours Away
registered_fosters$hoursAway <-sample(seq(1, 12, 1), 
                                      nrow(registered_fosters), 
                                      replace=TRUE)

# applicationId
application <- read.csv(paste(path,'Data/applications_data.csv',sep=''))
application <- application[c('applicationId','fosterId')]
registered_fosters<- merge(registered_fosters,application,by='fosterId')

# Write to csv
registered_fosters <- registered_fosters[order(registered_fosters$fosterId),features]
write.csv(registered_fosters, paste(path,'Data/registered_fosters.csv',sep=''),row.names = FALSE)
