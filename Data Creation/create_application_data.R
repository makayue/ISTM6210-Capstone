library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)

##########################################################
## Create Random Data for Foster Applications SQL Table ##
##########################################################

# The applications table includes all applications from foster applicants and registered fosters. 

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'
applicants <- read.csv(paste(path,'Data/foster_applicants.csv',sep=''))
reg_fosters <- read.csv(paste(path,'Data/registered_fosters.csv',sep=''))

set.seed(891)

# Define features
features <- c('applicationId','status','submissionDate','fosterId')

# applicationId
l <- (nrow(reg_fosters)+nrow(applicants))
applicationId <- paste('AP',1000:(1000+l-1),sep = '')
applications <- data.frame(applicationId)

# status, submissionDate
# applicants
s <- c('Submitted','Under Review','Denied')
app <- subset(applicants,select = 'fosterId')
app$status <- sample(s,nrow(app),replace = TRUE,prob = c(2/4,1/4,1/4))
app$submissionDate <- sample(seq(as.Date('2019/04/01'), as.Date('2019/04/30'), by='day'),nrow(app),replace = TRUE)

# registered fosters
fos <- subset(reg_fosters,select = 'fosterId')
fos$status <- 'Approved'
fos$submissionDate <- sample(seq(as.Date('2017/01/01'), as.Date('2019/03/30'), by='day'),nrow(fos),replace = TRUE)

# Combine to applications df
all <- rbind(app,fos)
applications <- merge(applications,all,by='row.names')
applications <- applications[,!(colnames(applications) %in% c('Row.names'))]

# Reorder to SQl table 
applications <- applications[order(applications$applicationId),features]

# Write to CSV
write.csv(applications,file='Data/applications_data.csv',row.names = FALSE)
