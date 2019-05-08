library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)

#########################################################
## Create Random Data for Employee SQL Table ##
#########################################################

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'

set.seed(234)

# Define features
features <- c('employeeId','title','grade','lastName','firstName','emailAddress','userAddress','userCity','userState',
              'userZipCode','phone','birthdate')

# employeeId
employeeId <- paste("EM",1000:1049,sep = '')
employees <- data.frame(employeeId)

# title
t <- c('Administrator','Foster Coordinator','Foster Volunteer')
employees$title <- sample(t,nrow(employees),replace = TRUE,prob = c(1/5,2/5,3/5))

# grade
g <- sample(seq(1,10,1),nrow(employees),replace = TRUE)
employees$grade <- g

# lastName, firstName
set.seed(4)
n <- setNames(as.data.frame(sample(randomNames(500),size=nrow(employees),replace = TRUE)),c('name'))
n_split <- separate(n,name,c('lastName','firstName'),sep=', ', remove=TRUE)
employees <- merge(employees,n_split,by='row.names')
employees <- employees[,2:6]


# emailAddress
for (r in employees) {
  employees$emailAddress <- paste(employees$lastName,substr(employees$firstName,1,1),'@shelter.org',sep='')
}

# userAddress, userCity, userState, userZipCode
addr <- read.csv(paste(path,'registered_fosters_addresses.csv',sep=''),header=TRUE)
employees <- merge(employees,addr,by='row.names')
employees <- employees[,2:11]

# Phone
employees$phone <- r_phone_numbers(50, use_hyphens = TRUE)

# Birthdate
bd <- sample(seq(as.Date('1947/01/01'), as.Date('2011/12/31'), by='day'),nrow(employees),replace = TRUE)
employees$birthDate <- bd

# Write CSV
employees <- employees[order(employees$employeeId),]
write.csv(employees,paste(path,'Data/employee_data.csv',sep=''),row.names = FALSE)
