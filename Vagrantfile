# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(2) do |config|

  # Use the same key for each machine
  config.ssh.insert_key = false

  config.vm.define "minkbehat_demo" do |minkbehat_demo|
    minkbehat_demo.vm.box = "ubuntu/trusty64"
    minkbehat_demo.vm.network "forwarded_port", guest: 80, host: 10080
    minkbehat_demo.vm.network "forwarded_port", guest: 443, host: 10443
    minkbehat_demo.vm.network "forwarded_port", guest: 8000, host:18000 
    minkbehat_demo.vm.network "forwarded_port", guest: 1080, host:11080
    minkbehat_demo.vm.network "forwarded_port", guest: 4444, host: 14444

    minkbehat_demo.vm.network "private_network", ip: "192.168.100.100"

    minkbehat_demo.vm.provider :virtualbox do | vb |

        vb.name = "minkbehat_demo"
        vb.gui = false # Hide/Show GUI Screen

        vb.customize ["modifyvm", :id, "--memory", "1024"]
        vb.customize ["modifyvm", :id, "--cpus", "1"]

    end

    minkbehat_demo.vm.synced_folder "./", "/var/www/demo", :type => "nfs", mount_options: ['rw', 'vers=3', 'tcp', 'fsc']

  end


  # ######################################################################################################
  # This keeps right sync folder. Needs vagrant-bind plugin (vagrant plugin install vagrant-bindfs)
  config.bindfs.bind_folder "/var/www/", "/var/www/", u: 'www-data', g: 'vagrant', perms: '0775'
  config.nfs.map_uid = Process.uid
  config.nfs.map_gid = Process.gid
  # ######################################################################################################

  config.vm.provision "shell", inline: "service apache2 restart", run: "always"

end
