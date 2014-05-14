Vagrant::Config.run do |config|
	config.vm.box = "osm_precise64_lamp"
  config.vm.box_url = "http://dev.opensourcemind.us/boxes/osm_precise64_lamp.box"
  config.vm.forward_port 80, 8888, :auto => true
  config.vm.forward_port 3306, 8777, :auto => true
	config.vm.share_folder "www", "/var/www", ".",  :owner => "www-data"
end
