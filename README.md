Westminster Hubble
==================

A site for connecting constituents with their MPs. Ran at http://westminsterhubble.com from 2010-2013. Now defunct due to lack of use, and open sourced.

Development
-----------

Westminster Hubble was developed and launched privately, but a short series of blog posts note its release, describe how it works behind the scenes, and sadly a few years later document its demise.

1. [Announching: Westminster Hubble](https://ianrenton.com/blog/announcing-westminster-hubble/)
2. [The Technology of Westminster Hubble](https://ianrenton.com/blog/the-technology-of-westminster-hubble/)
3. [The End of Westminster Hubble](https://ianrenton.com/blog/the-end-of-westminster-hubble/)

Install on Heroku
-----------------

```
git clone https://github.com/ianrenton/westminsterhubble.git
cd westminsterhubble
cp sample.env .env
vi .env
heroku apps:create mywestminsterhubbleapp
heroku config:push
git commit -a -m "If anything has changed..."
git push heroku master
```
