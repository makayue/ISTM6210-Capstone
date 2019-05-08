library(janitor)
library(digest)
library(generator)
library(tidyr)

#####################################################
## Create Random Data for Foster Account SQL Table ##
#####################################################

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\Data\\Test\\'

set.seed(234)

# Define features
features <- c('accountId', 'fosterPasswordHash', 'fosterId', 'applicantId')

# Load Fosters Data
fos <- read.csv(paste(path,'registered_fosters.csv',sep = ''),stringsAsFactors = FALSE)
fos <- setNames(fos[,c('fosterId','emailAddress')],c('fosterId','accountId'))
fos$applicantId <- NaN

# Load Applicants Data
app <- read.csv(paste(path,'foster_applicants.csv',sep=''),stringsAsFactors = FALSE)
app <- setNames(app[,c('fosterId','emailAddress')],c('applicantId','accountId'))
app$fosterId <- NaN
app <- app[,c('fosterId','accountId','applicantId')]

# Combine
fosters <- rbind(fos,app)

# Create hashed passwords
pw <- c('ILoveKittens88','puppyLove18','dogdogcat','meow1894!','woof18','itsadogslyfe1894','ILoveDogs2949','pass12345')
for (i in pw) {
  pw[i] <- digest(i, 'md5', serialize = FALSE)
}
pw <- pw[9:16]
fosters$fosterPasswordHash <- sample(pw,nrow(fosters),replace = TRUE)

# Export to csv
fosters <- fosters[,features]
write.csv(fosters, paste(path,'foster_accounts.csv',sep=''),row.names = FALSE)
