#AlValumUploadeBundle
The AlValumUploadeBundle encapsulates the ajax valum uploader javascript to manage the files uploading through a simple ajax interface.

## Get the PageTreeBundle
Clone this bundle in the vendor/bundles/AlphaLemon directory:

    git clone git://github.com/alphalemon/AlValumUploaderBundle.git vendor/bundles/AlphaLemon/AlValumUploaderBundle

## Configure the AlValumUploadeBundle
Open the AppKernel configuration file and add the bundle to the registerBundles() method, for the dev namespace:

    public function registerBundles()
    {
        $bundles = array(
            ...
            if (in_array($this->getEnvironment(), array('dev', 'test'))) {
                
                $bundles[] = new AlphaLemon\AlValumUploaderBundle\AlValumUploaderBundle();
            }
        )
    }

Register the AlValumUploaderBundle namespaces in `app/autoload.php`:

    $loader->registerNamespaces(array(
        ...
        'AlphaLemon'                     => __DIR__.'/../vendor/bundles',
    ));

## Configure the assets compressor
The uploader requires the yuicompressor.jar to be installed, so download it, open the config.yml and configure it as follows:

    assetic:
        ...
        filters:
            ...
            yui_js:
                jar: %kernel.root_dir%/Resources/java/yuicompressor.jar
            yui_css:
                 jar: %kernel.root_dir%/Resources/java/yuicompressor.jar

Install the assets as follows:

    app/console assets:install web --symlink


## Using the uploader
This part is under construction. Please see the ThemeEngineBundle ThemesController's showAction method for a working example

### Info and help
To get extra information or help you may write an email to info [at] alphalemon [DoT] com