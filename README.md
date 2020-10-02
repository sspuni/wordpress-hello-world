# wordpress-hello-world
Basic wordpress plugin to print Hello World in browser console if the currently opened post is the newest one

## Installation
- Download zip from https://github.com/sspuni/wordpress-hello-world/archive/main.zip
- Login to wordpress admin 
- Navigate to `Plugins -> Add New`
- Choose `Upload Plugin` -> `Choose file` -> `Install Plugin`

## Usage

Open browser console and navigate to the newest post on your wordpress blog. You should see `"Hello World!" -- <Your Post Title>`

## Running PHP Code Sniffer

- Open terminal / command prompt
- Navigate to project folder
- Execute `./vendor/bin/phpcs -l .`