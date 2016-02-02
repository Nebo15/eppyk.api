Vagrant.configure("2") do |config|

  config.vm.provider "virtualbox" do |provider, override|
    override.vm.box = "ubuntu/trusty64"
    override.vm.network "private_network", ip: "100.87.136.136"
    override.vm.synced_folder "", "/www/eppyk.backend",
        owner: "www-data", group: "www-data"
    provider.gui = false
    provider.customize ["modifyvm", :id, "--memory", "1024"]
    provider.customize ["modifyvm", :id, "--cpuexecutioncap", "50"]
    provider.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    provider.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    override.vm.provision "shell", inline: $virtualbox_script_app
  end

  config.vm.provider "digital_ocean" do |provider, override|
      override.vm.hostname = 'eppyk.api'
      override.ssh.username = 'samorai'
      override.vm.synced_folder '/www/eppyk.backend/puppet', "/www/puppet", owner: "www-data", group: "www-data"
      override.ssh.private_key_path = '~/.ssh/digitaloceanmbill'
      override.vm.box = 'digital_ocean'
      override.vm.box_url = "https://github.com/smdahlen/vagrant-digitalocean/raw/master/box/digital_ocean.box"
      provider.token = '636a98fe08d693bb2cb5a6808050c1268bac2ebbb70363ea413bdc267a214996'
      provider.image = 'ubuntu-14-04-x64'
      provider.region = 'ams2'
      provider.size = '512mb'
      provider.backups_enabled = true
      provider.setup = true
      override.vm.provision "shell", inline: $digital_ocean_script_app
  end
end

$virtualbox_script_app = <<SCRIPT
#!/bin/bash
set -o nounset -o errexit -o pipefail -o errtrace
trap 'error "${BASH_SOURCE}" "${LINENO}"' ERR
TIMEZONE="Europe/Kiev"
LOCALE_LANGUAGE="en_US"
LOCALE_CODESET="en_US.UTF-8"
sudo locale-gen ${LOCALE_LANGUAGE} ${LOCALE_CODESET}
sudo echo "export LANGUAGE=${LOCALE_CODESET}
export LANG=${LOCALE_CODESET}
export LC_ALL=${LOCALE_CODESET} " | sudo tee --append /etc/bash.bashrc
echo ${TIMEZONE} | sudo tee /etc/timezone
export LANGUAGE=${LOCALE_CODESET}
export LANG=${LOCALE_CODESET}
export LC_ALL=${LOCALE_CODESET}
sudo dpkg-reconfigure locales
echo 127.0.0.1 mbill.dev | sudo tee -a /etc/hosts
cd /www/mbill.web/puppet/initial
sudo /bin/bash init.sh -t 5422f61ca0f9e111ad9a8d6b8dc0d77e61597804 -r local
SCRIPT


$digital_ocean_script_app = <<SCRIPT
#!/bin/bash
set -o nounset -o errexit -o pipefail -o errtrace
trap 'error "${BASH_SOURCE}" "${LINENO}"' ERR
TIMEZONE="Europe/Kiev"
LOCALE_LANGUAGE="en_US"
LOCALE_CODESET="en_US.UTF-8"
sudo locale-gen ${LOCALE_LANGUAGE} ${LOCALE_CODESET}
sudo echo "export LANGUAGE=${LOCALE_CODESET}
export LANG=${LOCALE_CODESET}
export LC_ALL=${LOCALE_CODESET} " | sudo tee --append /etc/bash.bashrc
echo ${TIMEZONE} | sudo tee /etc/timezone
export LANGUAGE=${LOCALE_CODESET}
export LANG=${LOCALE_CODESET}
export LC_ALL=${LOCALE_CODESET}
sudo dpkg-reconfigure locales
cd /www/puppet/initial
sudo /bin/bash init.sh -t 5422f61ca0f9e111ad9a8d6b8dc0d77e61597804 -r develop
SCRIPT