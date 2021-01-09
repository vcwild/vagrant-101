# Vagrant 101

## Project requirements

Create a ssh key pair named "id_bionic" and "id_bionic.pub" and add it to the project root folder

```
ssh-keygen -t rsa
```

Move the public key to ./config

```
mv id_bionic.pub ./config/id_bionic.pub
```
