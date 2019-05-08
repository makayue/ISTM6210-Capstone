library(janitor)
library(stringi)
library(lubridate)

#########################################################
## Create Random Data for Animals SQL Table ##
#########################################################

path <- 'C:\\Users\\rbcha\\OneDrive - The George Washington University\\Spring 2019\\ISTM 6210\\ec2\\SQL\\'

animals <- read.csv(paste(path,'train.csv',sep=''),stringsAsFactors=FALSE) %>%
  clean_names()
exclude <- c('pet_id','color3','dewormed','quantity','health','fee','rescuer_id','video_amt',
             'photo_amt','adoption_speed','fur_length','state')
set.seed(12)
animals <- animals[which(animals$quantity==1),!(names(animals) %in% exclude)]

animal_set <- animals[sample(nrow(animals), 800),]

# Define Features
features <- c('animalId','animalName','location','age','ageStatus','microchipId','species','breed1',
              'breed2','sex','color1','color2','size','sterilized','vaccinated','houseTrained','registrationDate',
              'shelterTenure','specialNeeds','goodWithDogs','goodWithCats','goodWithOther','goodWithChildren',
              'fosterStatus', 'description','shelterId')

## Match animal_set columns to desired ##

# animalId
animal_set$animalId <- paste('AN',1000:1799,sep='')

# Breed1
breeds <- read.csv(paste(path,'breed_labels.csv',sep=''),stringsAsFactors = FALSE) %>%
  clean_names()
animal_set <- merge(x = animal_set, y = breeds, by.x = c('type','breed1'), by.y = c('type','breed_id'), all.x = TRUE)
animal_set <- animal_set[,!(names(animal_set) %in% c('breed1'))]
colnames(animal_set)[colnames(animal_set)=='breed_name'] <- 'breed1'

# Breed1
animal_set <- merge(x = animal_set, y = breeds, by.x = c('type','breed2'), by.y = c('type','breed_id'), all.x = TRUE)
animal_set <- animal_set[,!(names(animal_set) %in% c('breed2'))]
colnames(animal_set)[colnames(animal_set)=='breed_name'] <- 'breed2'

# Species
colnames(animal_set)[colnames(animal_set)=='type'] <- 'species'
animal_set$species <- ifelse(animal_set$species == 1, 'dog', 'cat')

# Size
colnames(animal_set)[colnames(animal_set)=='maturity_size'] <- 'size'
animal_set$size <- ifelse(animal_set$size == 1, 'small',
                          ifelse(animal_set$size == 2, 'medium',
                                 ifelse(animal_set$size == 3, 'large',
                                        ifelse(animal_set$size == 4, 'extra large', 'not specified'))))

# Gender
animal_set$sex <- ifelse(animal_set$gender == 1, 'male','female')

# Color1 and Color2
colors <- c('black','brown','golden','yellow','cream','gray','white')
for (val in unique(animal_set$color1)) {
  animal_set$color1[animal_set$color1==val] <- colors[val]
  animal_set$color2[animal_set$color2==val] <- colors[val]
}
animal_set$color2[animal_set$color2 == 0] <- 'None'

# Vaccinated
animal_set$vaccinated <- ifelse(animal_set$vaccinated == 1, 'yes', 'no')

# Sterilized
animal_set$sterilized <- ifelse(animal_set$sterilized == 1, 'yes', 'no')

# MicrochipId
m_id <- stri_rand_strings(nrow(animal_set),15)
animal_set$microchipId <- m_id

# HouseTrained
a <- c('yes','no')
ht <- sample(a,nrow(animal_set),replace = TRUE,prob = c(3/4,1/4))
animal_set$houseTrained <- ht

# Registration Date
dates <- sample(seq(as.Date('2019/01/01'), as.Date('2019/05/01'), by='day'),nrow(animal_set),replace = TRUE)
animal_set$registrationDate <- dates

# Shelter Tenure
today <- as.Date('2019/05/01')
animal_set$shelterTenure <- difftime(today,animal_set$registrationDate,units = 'days')

# Special Needs
s <- c('no','medical','behavioral')
sn <- sample(s,nrow(animal_set),replace=TRUE,prob=c(98/100,1/100,1/100))
animal_set$specialNeeds <- sn

# GoodWithDogs
d <- sample(a,nrow(animal_set),replace=TRUE)
animal_set$goodWithDogs <- d

# GoodWithCats
c <- sample(a,nrow(animal_set),replace=TRUE)
animal_set$goodWithCats <- c

# GoodWithChildren
ch <- sample(a,nrow(animal_set),replace=TRUE)
animal_set$goodWithChildren <- ch

# GoodWithOther
o <- sample(a,nrow(animal_set),replace=TRUE,prob=c(7/8,1/8))
animal_set$goodWithOther <- o

# FosterStatus
fs <- c('Available to foster','Pending','Not available to foster','Adopted')
fs_s <- sample(fs,nrow(animal_set),replace=TRUE,prob=c(5/20,2/20,5/20,8/20))
animal_set$fosterStatus <- fs_s

# Location - comes from SQL from foster activity
animal_set$location <- ifelse(animal_set$fosterStatus == 'Adopted', 'home',
                              ifelse(animal_set$fosterStatus == 'Not available to foster', 'foster home', 'shelter'))

# ageStatus
ages <- c('baby','young','adult','senior')
animal_set$ageStatus <- ifelse(animal_set$age <= 6, ages[1], 
                               ifelse(animal_set$age <=24, ages[2], 
                                      ifelse(animal_set$age < 72, ages[3], ages[4]
                                             )
                                      ))

# Rename and reorder columns 
colnames(animal_set)[colnames(animal_set)=='name'] <- 'animalName'
animal_set$animalName[animal_set$animalName == ''] <- 'No name'


animal_set <- animal_set[order(animal_set$animalId),features]

# Write to csv
write.csv(animal_set, paste(path,'Data/animal_data.csv',sep = ''), row.names = FALSE)
