library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)
library(lubridate)

######################################################
## Create Random Data for Foster Activity SQL Table ##
######################################################

# The foster activity table includes information about active fostering. 

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'

features <- c('activityId','type','approvalDate','duration','status','fosterId','animalId')


ar <- read.csv(paste(path,'Data/animalrequest_data.csv',sep=''))
ar$requestDate <- as.Date(ar$requestDate)
ar_active <- ar[ar$requestStatus=='Approved',]
ar_inactive <- ar[ar$requestStatus!='Approved',]

# type
type <- c('active','pending pickup','not active')
ar_active$type <- sample(type[1:2],nrow(ar_active),replace = TRUE,prob = c(2/3,1/3))
ar_inactive$type <- type[3]

# People who have approved animal requests and are actively fostering or pending pickup must have an approval date
ar_active$approvalDate <- ar_active$requestDate
for (foster in 1:nrow(ar_active)) {
  appDate <- sample(seq(ar_active$requestDate[foster],as.Date('2019/05/01'),'days'),1,replace = TRUE)
  ar_active$approvalDate[foster] <- appDate
}

# People whose requests are not approved with not have an approval date.
ar_inactive$approvalDate <- NA

# Recombine active and inactive
ar_all <- rbind(ar_active,ar_inactive)

# duration
today <- as.Date('2019/05/01')
ar_all$duration <- ifelse(!is.na(ar_all$requestDate), 
                          (difftime(today, as.Date(ar_all$approvalDate), units='days')),
                          NA)

# status
status <- c('approved','awaiting approval')
ar_all$status <- ifelse(ar_all$requestStatus=='Approved','approved','awaiting approval')

# activityId
ar_all$activityId <- paste('FA',1000:(999+nrow(ar_all)),sep='')

# Ensure proper columns and order
ar_all <- ar_all[order(ar_all$activityId),features]

# Write to csv
write.csv(ar_all,file=paste(path,'Data/activity_data.csv',sep=''),row.names = FALSE)
