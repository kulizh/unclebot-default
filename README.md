# unclebot-default
Simple framework to create tg-bots.

## Rewrites
Rewrites now available __only for apache2__, to make it works under nginx use your own .conf.

## Getting started
1. Clone repository
```bash
git clone git@github.com:kulizh/unclebot-default.git my-new-bot
```
... where `my-new-bot` is name of your bot folder. 

2. Remove `.git` folder
```bash
cd my-new-bot && rm -rf .git
```

3. Install dependencies via composer
```
cd data && composer install
```

4. Run SQL from `data/sql/creates.sql`.

5. Paste your database and tg configuration in `data/config` .ini-files.


## Folders
There are two folders: `htdocs` and `data`. The first one is webroot-directory, `data` in unavailable from web.
