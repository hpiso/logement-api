class Box
  def Box.configure(config, settings)
    # Configure The Box
    config.vm.box = "debian/jessie64"
    config.vm.hostname = settings["boxName"]
    config.vm.define settings["boxName"]

    # Configure A Private Network IP
    config.vm.network :private_network, ip: settings["ip"] ||= "192.168.7.30"

    # NFS
    config.vm.synced_folder ".", "/vagrant", nfs: true, mount_options: ['actimeo=2']

    if settings['networking'][0]['public']
      config.vm.network "public_network", type: "dhcp", bridge: "bridge0"
    end

    # Configure A Few VirtualBox Settings
    config.vm.provider "virtualbox" do |vb|
      vb.name = settings["boxName"]
      vb.customize ["modifyvm", :id, "--memory", settings["memory"] ||= "2048"]
      vb.customize ["modifyvm", :id, "--cpus", settings["cpus"] ||= "1"]
      vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
      vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
      vb.customize ["modifyvm", :id, "--ostype", "Debian_64"]
      vb.customize ["modifyvm", :id, "--audio", "none", "--usb", "off", "--usbehci", "off"]
    end

    # Configure Port Forwarding To The Box
    config.vm.network "forwarded_port", guest: 80, host: 1234

    # Add Custom Ports From Configuration
    if settings.has_key?("ports")
      settings["ports"].each do |port|
        config.vm.network "forwarded_port", guest: port["guest"], host: port["host"], protocol: port["protocol"] ||= "tcp"
      end
    end

    # Install php71
    config.vm.provision "shell" do |s|
      s.path = "./scripts/_php71-conf.sh"
    end

    if settings['sites'].kind_of?(Array)
      settings["sites"].each do |site|
        config.vm.provision "shell" do |s|
          s.args = [site["hostname"], site["to"]]
          s.path = "./scripts/_apache-conf.sh"
        end
      end
    end

    if !Vagrant::Util::Platform.windows?
      # Configure The Public Key For SSH Access
      settings["authorize"].each do |key|
        if File.exists? File.expand_path(key) then
          config.vm.provision "shell" do |s|
            s.inline = "echo $1 | grep -xq \"$1\" /home/vagrant/.ssh/authorized_keys || echo $1 | tee -a /home/vagrant/.ssh/authorized_keys"
            s.args = [File.read(File.expand_path(key))]
          end
        end
      end
      # Copy The SSH Private Keys To The Box
      settings["keys"].each do |key|
        if File.exists? File.expand_path(key) then
          config.vm.provision "shell" do |s|
            s.privileged = false
            s.inline = "echo \"$1\" > /home/vagrant/.ssh/$2 && chmod 600 /home/vagrant/.ssh/$2"
            s.args = [File.read(File.expand_path(key)), key.split('/').last]
         end
        end
      end
    end

    # Register All Of The Configured Shared Folders
    if settings['folders'].kind_of?(Array)
      settings["folders"].each do |folder|
        config.vm.synced_folder folder["map"], folder["to"], type: folder["type"] ||= nil
      end
    end

    # Configure All Of The Configured Databases
    if settings['databases'].kind_of?(Array)
      settings["databases"].each do |db|
          config.vm.provision "shell" do |s|
              s.path = "./scripts/_mysql-conf.sh"
              s.args = [db]
          end
      end
    end

    # Install composer
    config.vm.provision "shell" do |s|
      s.path = "./scripts/_composer-conf.sh"
    end

    # Install git
    config.vm.provision "shell" do |s|
      s.path = "./scripts/_git-conf.sh"
    end

    # Install npm
    config.vm.provision "shell" do |s|
      s.path = "./scripts/_npm-conf.sh"
    end

    # Install gulp
    config.vm.provision "shell" do |s|
      s.path = "./scripts/_gulp-conf.sh"
    end

  end
end

