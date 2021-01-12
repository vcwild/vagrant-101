$install_ansible = <<-SCRIPT
    apt-get update && \
    apt-get install -y software-properties-common && \
    apt-add-repository --yes --update ppa:ansible/ansible && \
    apt-get install -y ansible
SCRIPT



Vagrant.configure("2") do |config|
    config.vm.box = "ubuntu/bionic64"
    
    config.vm.provider "virtualbox" do |vb|
        vb.name = "ubuntu_bionic_config"
        vb.memory = 512
        vb.cpus = 1
    end

    config.vm.define "phpweb" do |phpweb|
        phpweb.vm.network "forwarded_port", guest: 8888, host: 8888
        phpweb.vm.network "public_network", bridge: "enp0s25", ip: "192.168.15.153"
        
        phpweb.vm.provider "virtualbox" do |vb|
            vb.name = "ubuntu_bionic_php"
            vb.memory = 1024
            vb.cpus = 2
        end

        phpweb.vm.provision "shell", 
            inline: "apt-get update && apt-get install -y puppet"

        phpweb.vm.provision "puppet" do |puppet|
            puppet.manifests_path = "./configs/manifests/"
            puppet.manifest_file = "phpweb.pp"    
        end
    end

    config.vm.define "mysqlserver" do |mysqlserver|
        mysqlserver.vm.network "public_network", bridge: "enp0s25", ip: "192.168.15.154"
        mysqlserver.vm.provision "shell", 
            inline: "cat /vagrant/configs/id_bionic.pub >> .ssh/authorized_keys"
    end

    # optional - provision a vm for ansible playbook scripting
    config.vm.define "ansible" do |ansible|
        ansible.vm.network "public_network", bridge: "enp0s25", ip: "192.168.15.155"
        ansible.vm.provision "shell",
            inline: $install_ansible
        ansible.vm.provision "shell",
            inline: "cp /vagrant/id_bionic /home/vagrant/id_bionic && \
            chmod 600 /home/vagrant/id_bionic && \
            chown vagrant:vagrant /home/vagrant/id_bionic"
        ansible.vm.provision "shell",
            inline: "ansible-playbook -i /vagrant/configs/ansible/hosts \
            /vagrant/configs/ansible/playbook.yml"
    end

    config.vm.define "memcache" do |memcache|
        memcache.vm.box = "centos/7"

        memcache.vm.provider "virtualbox" do |vb|
            vb.name = "centos7_memcache"
            vb.memory = 512
            vb.cpus = 1
        end
    end

end