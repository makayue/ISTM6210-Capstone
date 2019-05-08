

###########################################################
## Create Random Data for Foster App Decisions SQL Table ##
###########################################################


path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\Data\\Test\\'

features <- c('appDecisionId','applicationId','employeeId','fosterAppDecision','reasonCode','transDate')

# Get applications data
apps <- read.csv(paste(path,'applications_data.csv',sep=''))
apps$submissionDate <- as.Date(apps$submissionDate)
colnames(apps)[2] <- c('fosterAppDecision')
approved <- apps[apps$fosterAppDecision=='Approved',]
denied <- apps[apps$fosterAppDecision=='Denied',]


# Reason codes
rc <- c('Income Stability','Home Situation','Hours Away','Behavioral')
denied$reasonCode <- sample(rc,nrow(denied),replace = TRUE)
approved$reasonCode <- 'No Issues'
trans <- rbind(approved,denied)

# transDate
trans$transDate <- Sys.time()
for (i in 1:nrow(trans)) {
  submit <- trans$submissionDate[i]
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
  trans$transDate[i] <- td
}

# appDecisionId
trans <- trans[order(trans$transDate),]
trans$appDecisionId <- seq(1,nrow(trans),1)

# employeeId
emp <- read.csv(paste(path,'employee_data.csv',sep=''))
emp <- emp[emp$title !='Foster Volunteer','employeeId']
trans$employeeId <- sample(emp,nrow(trans),replace=TRUE)

# Read to csv
trans <- trans[,features]
write.csv(trans,paste(path,'appDec_data.csv',sep=''),row.names = FALSE)
