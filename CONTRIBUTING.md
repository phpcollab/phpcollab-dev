Guidelines for Contributing
====
Contributions from the community are essential in keeping phpCollab (any Open Source
project really) strong and successful.  While we try to keep requirements for
contributing to a minimum, there are a few guidelines we ask that you mind.

## Getting Started
If you are just getting started with Git, GitHub and/or contributing to phpCollab via
GitHub there are a few pre-requisite steps.

* Make sure you have a [GitHub account](https://github.com/signup/free)
* [Fork](http://help.github.com/fork-a-repo) the phpCollab repository.  As discussed in
the linked page, this also includes:
    * [Set](https://help.github.com/articles/set-up-git) up your local git install
    * Clone your fork


## Create the working (topic) branch
Create a "topic" branch on which you will work.  The convention is to name the branch
using the phpCollab issue key.  If there is not already a phpCollab issue covering the work you
want to do, create one.  Assuming you will be working from the master branch and working
on the phpCollab 123 issue : `git checkout -b phpC-123 master`

## Code
Do yo thang!

## Commit

* Make commits of logical units.
* Be sure to use the phpCollab issue key in the commit message.  This is how phpCollab will pick
up the related commits and display them on the phpCollab issue.
* Make sure you have added the necessary tests for your changes.
* Run _all_ the tests to assure nothing else was accidentally broken.

_Prior to commiting, if you want to pull in the latest upstream changes (highly
appreciated btw), please use rebasing rather than merging.  Merging creates
"merge commits" that really muck up the project timeline._

## Submit
* Push your changes to a topic branch in your fork of the repository.
* Initiate a [pull request](http://help.github.com/send-pull-requests/)
* Update the phpCollab issue, adding a comment including a link to the created pull request.