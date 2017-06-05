require 'json'
require 'yaml'

VAGRANTFILE_API_VERSION = "2"

confYamlPath    = File.expand_path("./conf.yaml")
afterScriptPath = File.expand_path("./scripts/_customize.sh")
require_relative 'scripts/Box.rb'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
	config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"

	Box.configure(config, YAML::load(File.read(confYamlPath)))

	if File.exists? afterScriptPath then
		config.vm.provision "shell", path: afterScriptPath
	end
end
