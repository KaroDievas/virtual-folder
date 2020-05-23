# virtual-folder

## Requirements
- docker

## Running
- docker-compose up
- docker exec -it virtual-folder sh
= phpunit tests
- php src/app.php [command] [argument] [argument2]

### Commands provided

- help
- folderCreate [folderName]
- folderRemove [folderName] 
- tree - gets whole tree
- tree [path] - you can view any directory tree
- listFiles - lists all files in all directories
- listFiles [path] - list files in any folder
- uploadFile [fileFromLocalDirectory] [pathToUpload]
- removeFile [removeFilePath]
- backup

### Uploading files
- local storage = project root directory
- In case you want to access any file from not inside docker, you need to have php directly written into your PC, and move data folder into projects root in order to file system could see. (let's discuss that)

### Notes
Data persists only for that moments if you do not rebuild whole docker container. I have decided to move whole data inside to docker container in order to not have any any .gitignore in data folder visible from IDE. This allows me to not care is it really uploaded files or not.

### Possible improvements
- Move any configuration stuff to .yml files and load them
- Provide more nicer documentations using help
- handle more exceptions and warning