
#########################################################
## Create Random Data for Shelter_Trans SQL Table ##
#########################################################

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\Data\\'

# Define features
features <- c('shelterTransId', 'transType', 'transDate', 'employeeId', 'shelterId')

# shelterId
shelter <- read.csv(paste(path,'Test/shelters_data.csv',sep=''))
shelter <- as.data.frame(shelter[,'shelterId'])
colnames(shelter) <- 'shelterId'
shelterTrans <- shelter

## "Add" Transactions
# transDate
datetime <- seq.POSIXt(ISOdate(2018,5,1), ISOdate(2018,12,31), "min")
shelterTrans$transDate <- as.Date('2018-05-01')
shelterTrans$transDate <- sample(datetime,nrow(shelterTrans),replace = TRUE)
shelterTrans$transType <- 'add'


## "Update" Transactions
datetime <- seq.POSIXt(ISOdate(2019,1,1), ISOdate(2019,5,1), "min")
shelter$transDate <- as.Date('2018-05-01')
shelter$transDate <- sample(datetime,nrow(shelter),replace = TRUE)
shelter$transType <- 'update'

## Combine two date ranges
shelterTrans <- rbind(shelterTrans, shelter)

# employeeId
emp <- read.csv(paste(path,'Test/employee_data.csv',sep=''))
emp <- emp[emp$title != 'Foster Volunteer','employeeId']
shelterTrans$employeeId <- sample(emp, nrow(shelterTrans), replace = TRUE)

# shelterTransId
shelterTransId <- seq(1,nrow(shelterTrans),1)
shelterTrans$shelterTransId <- shelterTransId

# Save
shelterTrans <- shelterTrans[order(shelterTrans$transDate),features]
write.csv(shelterTrans, paste(path,'Test/shelterTrans_data.csv',sep=''),row.names = FALSE)

