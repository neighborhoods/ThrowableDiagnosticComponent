# Upgrading from 3.* to 4.*

In version 4 all components have been versioned. The structure is refactored causing changes in namespaces, paths and fabricated method names.

Require version 4 using composer.
```bash
composer require neighborhoods/throwable-diagnostic-component:^4
```
This might fail due to multiple reasons:
* Another dependency requires version 3  
 Most likely the KojoWorkerDecoratorComponent. Update the dependency first. If the dependency doesn't have a later version compatible with throwable diagnostic component 4, contact the owner to add support for it.
* Buphalo fails  
Some products run the buphalo script as part of composer's post-install or post-update script. Composer won't be able to complete the update since the buphalo files changed. Temporary exclude the buphalo script from composer scripts.
* You use test helpers from version 3  
The `test` folder has also been restructured. If some of your tests use test helpers for your custom decorators, update their paths by running
```bash
sed -i 's/\(vendor\/neighborhoods\/throwable-diagnostic-component\/test\/\)Decorator/\1ThrowableDiagnosticV1Decorators/g' composer.json
```

Common (not decorator specific) code has been moved from `src` to `src/ThrowableDiagnosticV1`.

Decorators have been moved from `src/ThrowableDiagnostic` into their own versioned directory. For example `src/ThrowableDiagnostic/GuzzleDecorator.php` is now in `src/ThrowableDiagnosticV1Decorators/GuzzleV1/GuzzleDecorator.php` along with accompanying files.

To quickly switch to the new file structure run the following regex **inside** your source and possibly test folders.
```bash
cd src

# fix namespaces
grep -RiIl 'ThrowableDiagnostic\\Aws' | xargs sed -i 's/ThrowableDiagnostic\\Aws\\\(.*\)Decorator/ThrowableDiagnostic\\Aws\1Decorator/g'
grep -RiIl 'ThrowableDiagnosticComponent\\ThrowableDiagnostic' | xargs sed -i 's/ThrowableDiagnosticComponent\\ThrowableDiagnostic\\\(.\+\)Decorator/ThrowableDiagnosticComponent\\ThrowableDiagnosticV1Decorators\\\1V1\\\1Decorator/g'
grep -RiIl 'ThrowableDiagnosticComponent\\ThrowableDiagnostic' | xargs sed -i 's/ThrowableDiagnosticComponent\\\(ThrowableDiagnostic[^V]\)/ThrowableDiagnosticComponent\\ThrowableDiagnosticV1\\\1/g'
grep -RiIl 'ThrowableDiagnosticComponent\\Diagnosed' | xargs sed -i 's/ThrowableDiagnosticComponent\\Diagnosed/ThrowableDiagnosticComponent\\ThrowableDiagnosticV1\\Diagnosed/g'

# fix getters and setters from fabricated aware traits
grep -RiIl 'etThrowableDiagnostic' | xargs sed -i 's/etThrowableDiagnostic\(.\+\)Decorator/etThrowableDiagnosticV1Decorators\1V1\1Decorator/g'
grep -RiIl 'etThrowableDiagnostic' | xargs sed -i 's/et\(ThrowableDiagnostic[^V]\)/etThrowableDiagnosticV1\1/g'
grep -RiIl 'etDiagnosed' | xargs sed -i 's/etDiagnosed/etThrowableDiagnosticV1Diagnosed/g'

# fix paths
grep -RiIl 'throwable-diagnostic-component' | xargs sed -i 's/^\(.*vendor\/neighborhoods\/throwable-diagnostic-component\)\/src\(.*\)$/\1\/fab\2\n\1\/src\2/g'

#fix buphalo templates
grep -RiIl 'template: ThrowableDiagnostic\/Decorator\/MessageBasedDecorator' | grep \.buphalo\.v1\.fabrication\.yml$ | xargs sed -i 's/template: ThrowableDiagnostic\/Decorator\/MessageBasedDecorator/template: ThrowableDiagnosticComponent\/ThrowableDiagnosticV1\/DiagnosingMessageBasedDecoratorV1\/PrimaryActorName/g'
grep -RiIl 'template: ThrowableDiagnostic\/Decorator\/PrimaryActorName' | grep \.buphalo\.v1\.fabrication\.yml$ | xargs sed -i 's/template: ThrowableDiagnostic\/Decorator\/PrimaryActorName/template: ThrowableDiagnosticComponent\/ThrowableDiagnosticV1\/DiagnosingDecoratorV1\/PrimaryActorName/g'
grep -RiIl 'template: PrimaryActorName\/ThrowableDiagnostic\/' | grep \.buphalo\.v1\.fabrication\.yml$ | xargs sed -i 's/template: PrimaryActorName\/ThrowableDiagnostic\//template: ThrowableDiagnosticComponent\/ThrowableDiagnosticV1\/DiagnoserV1\/PrimaryActorName\/ThrowableDiagnostic\//g'

cd ..
# do the same in the test folder
```
Review the changes after running the commands. Having a clean git repository will make it easier.  

Since version 4 the code is split in source and fabricated. Container builders will need to include both. The command above will modify the container builder code, but the result might need additional changes.

Buphalo fabricated files, but before that update the path to the template tree.
```bash
sed -i 's/\(vendor\/neighborhoods\/throwable-diagnostic-component\/template-tree\/\)V1/\1BuphaloV1/g' bin/buphalo
```
If you had the buphalo script as part of the composer scripts, enable them.
Run `composer dump-autload` just in case. Clean the cache (built containers).

If your tests use the test helpers step into the test folder and run the command below. 
```bash
grep -RiIl 'ThrowableDiagnosticComponentTest\\Decorator' | xargs sed -i 's/ThrowableDiagnosticComponentTest\\Decorator/ThrowableDiagnosticComponentTest\\ThrowableDiagnosticV1Decorators/g'
```

The migration should be complete. Run tests to see if there are any missed places or anything changed which wasn't supposed to.
