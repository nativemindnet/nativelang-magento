# 🌐 nativelang_magento

Welcome to `nativelang_magento`! This module enhances your Magento store with advanced translation capabilities. 🚀

## Prerequisites

Before proceeding with the installation of `nativelang_magento`, ensure you have:

1. **Magento 2 Installed** 🛠️

   This module requires a running Magento 2 installation. Ensure your Magento 2 store is up and running.

## 🛠️ Installation

1. **Download the Module** 📦
   
   Download `nativelang_magento` to your local machine.

2. **Upload to Magento** 📤

   Place the module folder in the Magento directory: `/app/code/`. You might need to create the directory structure if it doesn't exist.

3. **Enable the Module** 🌐

   Run the following commands from your Magento root directory to enable `nativelang_magento`:
   - `php bin/magento setup:upgrade`
   - `php bin/magento module:enable NativeMind_NativeLangMagento`
   - `php bin/magento setup:di:compile`
   - `php bin/magento cache:flush`

## 🔌 Activation

1. **Configure the Module** ✅

   After installation, log in to your Magento Admin, navigate to `Stores` > `Configuration` > `NATIVELANG` > `NativeLang Magento Settings`, and configure the module as needed.

Your store is now ready to embrace multilingual content! 🌍
---

If you have suggestions or improvements, feel free to open an issue or submit a pull request. Happy translating! 🎉
