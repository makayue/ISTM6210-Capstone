###############################################################
## Create Random Data for Animal Request Decisions SQL Table ##
###############################################################


path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\Data\\Test\\'

features <- c('requestDecId','employeeId','requestId','decision','reasonCode','transDate')

# Get applications data
req <- read.csv(paste(path,'animalrequest_data.csv',sep=''))
req$requestDate <- as.Date(req$requestDate)
colnames(req)[5] <- c('decision')
approved <- req[req$decision=='Approved',]

# employeeId
emp <- read.csv(paste(path,'employee_data.csv',sep=''))
emp <- emp[emp$title !='Administrator','employeeId']
approved$employeeId <- sample(emp,nrow(approved),replace=TRUE)

# transDate
approved$transDate <- Sys.time()
for (i in 1:nrow(approved)) {
  submit <- approved$requestDate[i]
  start <- submit + sample(1:7,1)
  sy <- as.numeric(substr(start,1,4))
  sm <- as.numeric(substr(start,6,7))
  sd <- as.numeric(substr(start,9,10))
  end <- start + 1
  ey <- as.numeric(substr(end,1,4))
  em <- as.numeric(substr(end,6,7))
  ed <- as.numeric(substr(end,9,10))
  date <- seq.POSIXt(ISOdate(sy,sm,sd), ISOdate(ey,em,ed), "min")
  td <- sample(date,1,replace=TRUE)
  approved$transDate[i] <- td
}

# requestDecId
approved <- approved[order(approved$transDate),]
approved$requestDecId <- seq(1,nrow(approved),1)

# reasonCode
approved$reasonCode <- 'No issues'

# Save
approved <- approved[,features]
write.csv(approved,paste(path,'reqDec_data.csv',sep=''),row.names = FALSE)
