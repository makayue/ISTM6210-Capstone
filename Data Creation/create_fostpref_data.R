library(janitor)
library(stringi)
library(randomNames)
library(generator)
library(tidyr)

##########################################################
## Create Random Data for Foster Preference SQL Table ##
##########################################################

# The foster preference table includes information about the animal preference of registered fosters and foster applicants. 

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'


# Get fosterIds from registered_fosters and foster_applicants tables. 
regfos <- read.csv(paste(path,'Data/registered_fosters.csv',sep=''))
regfos <- regfos[,c('fosterId','specialNeedsExp')]
fosapp <- read.csv(paste(path,'Data/foster_applicants.csv',sep=''))
fosapp <- fosapp[,c('fosterId','specialNeedsExp')]
allfos <- rbind(regfos,fosapp)

# Define features
features <- c('preferenceId','shelter1','shelter2','species','size','age',
              'specialNeeds','fosterToAdopt','availableNow','animalCount','fosterId')

# preferenceId
preferenceId <- paste('FP',1000:(999+nrow(allfos)),sep='')
foster_pref <- data.frame(preferenceId)

# shelter1
sh <- read.csv(paste(path,'Data/shelters_data.csv',sep=''))
sh <- sh[sh$euthStatus=='no euthanasia',]
shelters <- sh[,'shelterId']
foster_pref$shelter1 <- sample(shelters,nrow(foster_pref),replace = TRUE)

# shelter2
for (foster in 1:nrow(foster_pref)) {
  s1 <- foster_pref$shelter1[foster]
  s <- shelters[shelters!=s1]
  s <- droplevels(s)
  s <- levels(s)
  s2 <- sample(s,1)
  foster_pref$shelter2[foster] <- s2
}

# species
sp <- c('cat','dog','any')
foster_pref$species <- sample(sp,nrow(foster_pref),replace = TRUE)

# size
sz <- c('small','medium','large','any')
foster_pref$size <- ifelse(foster_pref$species == 'cat', 'small', 
                           sample(sz,nrow(foster_pref),replace=TRUE))

# age
age <- c('baby','young','adult','senior','any')
foster_pref$age <- sample(age,nrow(foster_pref),replace = TRUE,prob = c(1/10,2/10,2/10,2/10,3/10))

# specialNeeds
yn <- c('yes','no')
allfos$specialNeeds <- ifelse(allfos$specialNeedsExp == 'yes',
                              sample(yn,nrow(allfos),replace = TRUE,prob = c(4/5,1/5)),
                              sample(yn,nrow(allfos),replace = TRUE,prob = c(1/5,4/5)))

# fosterId
foster_pref <- merge(foster_pref,allfos,by='row.names')

# fosterToAdopt
foster_pref$fosterToAdopt <- sample(yn,nrow(foster_pref),replace = TRUE,prob = c(1/4,3/4))

# animalCount
foster_pref$animalCount <- sample(seq(1:5),nrow(foster_pref),replace = TRUE,prob = c(10/25,7/25,4/25,2/25,1/25))

# availableNow
foster_pref$availableNow <- sample(yn,nrow(foster_pref),replace = TRUE,prob = c(4/5,1/5))

# Reorder and only include features columns
foster_pref <- foster_pref[order(foster_pref$preferenceId),features]

# Write to csv
write.csv(foster_pref,file='Data/fosterpref_data.csv',row.names = FALSE)



