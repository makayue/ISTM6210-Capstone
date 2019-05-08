library(janitor)
library(digest)
library(generator)
library(tidyr)

############################################################
## Create Random Data for Administrator Account SQL Table ##
############################################################

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'

set.seed(234)

# Define features
features <- c('adminId', 'employeeId', 'adminPasswordHash', 'permissionLevel')

# Load Employees Data
emp <- read.csv(paste(path,'Data/employee_data.csv',sep=''))
admins <- subset(emp, emp$title=='Administrator')

# Define adminId
admins$adminId <- paste('AD',1000:(999+nrow(admins)),sep='')

# Create hashed passwords
pw <- c('ILoveKittens88','puppyLove18','dogdogcat','meow1894!','woof18','itsadogslyfe1894','ILoveDogs2949','pass12345')
for (i in pw) {
  pw[i] <- digest(i, 'md5', serialize = FALSE)
}
admins$adminPasswordHash <- pw[9:16]

# Define permissionLevel (1 - lowest, 3 - highest)
admins$permissionLevel <- sample(1:3, nrow(admins), replace=TRUE)

# Filter to desired features and write to csv
admins <- admins[,features]
write.csv(admins, paste(path, 'Data/admin_accounts.csv',sep = ''), row.names = FALSE)
