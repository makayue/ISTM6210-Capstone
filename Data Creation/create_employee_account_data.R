library(janitor)
library(digest)
library(generator)
library(tidyr)

#####################################################
## Create Random Data for Foster Account SQL Table ##
#####################################################

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\Data\\Test\\'


# Define features
features <- c('employeeAcctId', 'accountPasswordHash', 'employeeId')

# Load Employees Data
emp <- read.csv(paste(path,'employee_data.csv',sep=''))
colnames(emp)[6] <- 'employeeAcctId'

# Create hashed passwords
pw <- c('ILoveKittens88','puppyLove18','dogdogcat','meow1894!','woof18','itsadogslyfe1894','ILoveDogs2949','pass12345')
hashes <- vector()
for (i in 1:length(pw)) {
  hash <- digest(pw[i], 'md5', serialize = FALSE)
  hashes <- c(hashes,hash)
}
emp$accountPasswordHash <- sample(hashes,nrow(emp),replace = TRUE)

# Export to csv
emp <- emp[,features]
write.csv(emp, paste(path,'employee_accounts.csv',sep=''),row.names = FALSE)
