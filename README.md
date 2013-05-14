Westminster Hubble
==================

Describe me here

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