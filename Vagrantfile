# -*- mode: ruby -*-
# vi: set ft=ruby :

# https://gist.github.com/weppos/6391
# add recursive merge method to combine standard and custom config
class Hash
    def rmerge!(other_hash)
        merge!(other_hash) do |key, oldval, newval|
            oldval.class == self.class ? oldval.rmerge!(newval) : newval
        end
    end

    def rmerge(other_hash)
        r = {}
        merge(other_hash) do |key, oldval, newval|
            r[key] == self.class ? oldval.rmerge(newval) : newval
        end
    end
end

# Load standard config
require 'yaml'
begin
  vagrant_config = YAML.load_file(File.join(File.dirname(__FILE__), 'Vagrantconfig.yaml'))
rescue
  abort('Missing or bad Vagrantconfig.yaml file')
end

if File.exist? 'Vagrantconfig.custom.yaml'
  # load custom config
  begin
    custom_config = YAML.load_file(File.join(File.dirname(__FILE__), 'Vagrantconfig.custom.yaml'))

    # combine configs
    vagrant_config.rmerge!(custom_config)
  rescue
    abort('Missing or bad Vagrantconfig.custom.yaml file')
  end
end

if !vagrant_config.has_key? 'boxes'
  abort('Missing \'boxes\' config key')
end

# default synced directories
synced_dirs = {}
if vagrant_config.has_key? 'synced_directories'
    synced_dirs = vagrant_config['synced_directories']
end

# default provisioners
provisioners = {}
if vagrant_config.has_key? 'provisioners'
    provisioners = vagrant_config['provisioners']
end

# configure VMs
Vagrant.configure(2) do |config|
  vagrant_config['boxes'].keys.sort.each do |boxname|
    box_config = vagrant_config['boxes'][boxname]

    next unless box_config['enabled']

    config.vm.define boxname do |box|
      box.vm.box     = box_config['box_name']
      box.vm.box_url = box_config['box_url']

      box.vm.provider :virtualbox do |vb|
        vb.name = "#{box_config['hostname']}-#{Time.now.to_i}"
        config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"

        if box_config.has_key? 'memory'
          vb.customize ['modifyvm', :id, '--memory', box_config['memory']]
        end
      end

      box.vm.network :private_network, ip: box_config['host_ip']

      if box_config.has_key? 'public_network_enabled' and box_config['public_network_enabled']
        if box_config.has_key? 'network_bridge'
          bridge = box_config['network_bridge']
        else
          bridge = nil
        end

        if box_config.has_key? 'public_ip' and box_config['public_ip']
          box.vm.network :public_network, :ip => box_config['public_ip'], :bridge => bridge
        elsif box_config.has_key? 'public_mac' and box_config['public_mac']
          box.vm.network :public_network, :mac => box_config['public_mac'], :bridge => bridge
        else
          box.vm.network :public_network, :bridge => bridge
        end
      end

      box.vm.hostname = box_config['hostname']

      # synced directories
      if box_config.has_key? 'synced_directories'
        synced_dirs.rmerge(box_config['synced_directories']).each do |name, share|
          box.vm.synced_folder share['from'], share['to'], share['options']
        end
      end

      tmp_provisioners = {};
      # provisioners
      if box_config.has_key? 'provisioners'
        tmp_provisioners = provisioners.rmerge(box_config['provisioners'])
      else
        tmp_provisioners = provisioners
      end

      # provisioners - shell
      if tmp_provisioners.has_key? 'shell'
        tmp_provisioners['shell'].each do |idx, shell|
          box.vm.provision :shell, :path => shell['path']
        end
      end
    end
  end
end
