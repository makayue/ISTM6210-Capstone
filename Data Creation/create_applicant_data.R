library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)
library(lubridate)

#########################################################
## Create Random Data for foster_applicants SQL Table ##
#########################################################

# The foster applicants table includes information of people who have applied to become a foster. 

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'

set.seed(123)

# Define features
features <- c('fosterId','lastName','firstName','emailAddress','gender','userAddress','userCity','userState','userZipCode','phone',
              'birthDate','employmentStatus','specialNeedsExp','hoursAway', 'applicationId')

# fosterId
reg_fos <- read.csv(paste(path,'Data/registered_fosters.csv',sep=''))
app_lng <- 100
lng <- 1000+nrow(reg_fos)
fosterId <- paste('FO',lng:(lng+app_lng-1),sep = '')
foster_applicants <- data.frame(fosterId)

# Female Fosters
n <- setNames(as.data.frame(randomNames((1/2*app_lng),gender = 1)), c('name'))
n_split <- separate(n,name,c('lastName','firstName'),sep = ', ', remove = TRUE)
n_split$gender <- 'female'

# Male Fosters
mn <- setNames(as.data.frame(randomNames((1/2*app_lng),gender = 2)), c('name'))
mn_split <- separate(mn,name,c('lastName','firstName'),sep = ', ', remove = TRUE)
mn_split$gender <- 'male'

n_total <- rbind(n_split,mn_split)
n_total <- n_total[sample(nrow(n_total)),]

# Add foster names
foster_applicants <- merge(foster_applicants,n_total,by='row.names')

# emailAddress
dom <- c('yahoo.com','gmail.com','aol.com','msn.com')
for (r in foster_applicants) {
  foster_applicants$emailAddress <- paste(foster_applicants$lastName,substr(foster_applicants$firstName,1,1),'@',
                                           sample(dom,replace = TRUE),sep='')
}

# userAddress, userCity, userState, userZipCode
addr <- read.csv(paste(path,'registered_fosters_addresses.csv',sep=''),header=TRUE)
foster_applicants <- merge(foster_applicants,addr,by='row.names')

# Phone
foster_applicants$phone <- r_phone_numbers(nrow(foster_applicants), use_hyphens = TRUE)

# Birthdate
bd <- sample(seq(as.Date('1947/01/01'), as.Date('2011/12/31'), by='day'),nrow(foster_applicants),replace = TRUE)
foster_applicants$birthDate <- bd

# Employment Status
es <- c('Employed','Unemployed','Student')
foster_applicants$employmentStatus <- ifelse(year('2019-05-01')-year(foster_applicants$birthDate) > 65, 'Retired',
                                             sample(es,nrow(foster_applicants),replace=TRUE,prob = c(3/6,1/6,2/6)))

# Special Needs Experience
yn <- c('yes','no')
foster_applicants$specialNeedsExp <- sample(yn,nrow(foster_applicants),replace = TRUE,prob = c(1/4,3/4))

# Hours Away
foster_applicants$hoursAway <-sample(seq(1, 12, 1), nrow(foster_applicants), replace=TRUE)

# Application Id
application <- read.csv(paste(path,'Data/applications_data.csv',sep=''))
application <- application[c('applicationId','fosterId')]
foster_applicants <- merge(foster_applicants,application,by='fosterId')

# Write to csv
foster_applicants <- foster_applicants[order(foster_applicants$fosterId),features]
write.csv(foster_applicants, paste(path,'Data/foster_applicants.csv',sep=''),row.names = FALSE)
