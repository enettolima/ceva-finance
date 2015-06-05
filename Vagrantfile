Vagrant.configure("2") do |config|
	config.vm.box = "ubuntu/trusty64"
	config.vm.provision :shell, path: "vagrant/provision.sh"
	config.vm.network "public_network"
  config.vm.network "forwarded_port", guest: 80, host: 8888
  config.vm.network "forwarded_port", guest: 3306, host: 33060
	config.vm.synced_folder ".", "/var/www", owner: "www-data", group: "www-data"
end
