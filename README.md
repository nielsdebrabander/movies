# Odisee helpdesk

A fictional application that will be created, step by step, during the labo moments and workshop for "Web & Mobile Server-side"


# Rules

## Code style

Good code is consistent code, in both idea as style.


# Infrastructure

## Docker

This project has been setup with a multi container docker system.
This means that, if your Docker is running, you'll be able to bootstrap by

```
docker-compose up -d
```

If there is a need to use or so something with PHP, you'll need to use the php that is used by the containers

```
docker-compose exec php-web bash
```

## GIT

This repository is your base or goto place for the original codebase and any updates for the future labos.

Keep yourself in sync with this repo

### Steps

**Account**

Make sure you have an account for git.ikdoeict.be.

**Fork**

Fork this repo as an own project. You'll find a link on https://git.ikdoeict.be/pieter.vanpeteghem/odisee-helpdesk

**Commit and push**

We're not pushing you to use the command line. A GUI, like Sourcetree, can help you very well.

Try to keep your commits as small and functional as possible. This means that you'll commit for every feature that has been added.

If you added files, you'll need to add these to the repo as well
```
git add $filename1 $filename2
git add -A
```

You will need to commit the changes and additions too.
```
git commit $filename1 $filename2 -m "This is the comment, make it interesting and readable"
# or
git commit -am "This is the comment, make it interesting and readable"
```

After any commit, you'll push the code to the repo
```
git push -u origin master
```