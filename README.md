# PHPUnitFilterBlocker

PHPUnitFilterBlocker is custom implementation of PHPUnit Framework TestListener. It mainly blocks PHPUnit's filter option to prevent misconfiguration in CI.

## Installation

```
$ composer require genkiroid/phpunit-filter-blocker
```

## Settings

To attach PHPUnitFilterBlocker as test listener, add following element to phpunit.xml. (Parent element is `<phpunit>`.)

```xml
<listeners>
    <listener class="PHPUnitFilterBlocker\Listener">
        <arguments>
            <array>
                <element key="blockGroup">
                    <boolean>false</boolean>
                </element>
                <element key="blockExcludeGroup">
                    <boolean>false</boolean>
                </element>
            </array>
        </arguments>
    </listener>
</listeners>
```

If you want to block `--group` and `--exclude-group` options too, change `false` to `true` setting value above.

## About blocking

Block test case specification. (Fixed)
```
$ vendor/bin/phpunit tests/exampleTest.php
PHPUnit 9.0.1 by Sebastian Bergmann and contributors.

Test case specification has been disabled by phpunit-filter-blocker. Stopped phpunit.
```

Block `--filter` option. (Fixed)
```
$ vendor/bin/phpunit tests/ --filter="Hello"
PHPUnit 9.0.1 by Sebastian Bergmann and contributors.

--filter option has been disabled by phpunit-filter-blocker. Stopped phpunit.
```

Block `--group` option. (Option)
```
$ vendor/bin/phpunit tests/ --group=hello
PHPUnit 9.0.1 by Sebastian Bergmann and contributors.

--group option has been disabled by phpunit-filter-blocker. Stopped phpunit.
```

Block `--exclude-group` option. (Option)
```
$ vendor/bin/phpunit tests/ --exclude-group=hello
PHPUnit 9.0.1 by Sebastian Bergmann and contributors.

--group option has been disabled by phpunit-filter-blocker. Stopped phpunit.
```

No blocking example.
```
$ vendor/bin/phpunit tests/
PHPUnit 9.0.1 by Sebastian Bergmann and contributors.

..                                                                  2 / 2 (100%)

Time: 83 ms, Memory: 6.00 MB

OK (2 tests, 2 assertions)
```

