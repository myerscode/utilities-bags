# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## [2026.0.0] - 2026-03-24
### New Features
- [`d766f97`](https://github.com/myerscode/utilities-bags/commit/d766f977c8abb665bc3d909c27e085188daaf6b0) - **bag**: add first and last methods *(commit by [@oniice](https://github.com/oniice))*
- [`7397a13`](https://github.com/myerscode/utilities-bags/commit/7397a13f3b5a7d0648f7ff30cf8fe7c5ca0cbd0b) - **bag**: add reduce method *(commit by [@oniice](https://github.com/oniice))*
- [`e2735c3`](https://github.com/myerscode/utilities-bags/commit/e2735c382eb506438fcc8c3051b4f1f063a7ac5b) - **bag**: add isEmpty and isNotEmpty methods *(commit by [@oniice](https://github.com/oniice))*
- [`f6bc7cc`](https://github.com/myerscode/utilities-bags/commit/f6bc7cc331bdfe6fa69d3bdc4529f831fbf82ca5) - **bag**: add sort and sortBy methods *(commit by [@oniice](https://github.com/oniice))*
- [`a987f74`](https://github.com/myerscode/utilities-bags/commit/a987f7490b87361287cbca767a19a58c8356c397) - **bag**: add unique method *(commit by [@oniice](https://github.com/oniice))*
- [`d57992d`](https://github.com/myerscode/utilities-bags/commit/d57992d9160fa623036f4f69532ef1e8d15874c4) - **bag**: add pluck method *(commit by [@oniice](https://github.com/oniice))*
- [`e3e8abb`](https://github.com/myerscode/utilities-bags/commit/e3e8abb41ade8f02f0022c9ec2f619434a5b7146) - **bag**: add groupBy method *(commit by [@oniice](https://github.com/oniice))*
- [`3376c05`](https://github.com/myerscode/utilities-bags/commit/3376c0587a84291a447b05263a20210d4e9c6abd) - **bag**: add sum, min and max methods *(commit by [@oniice](https://github.com/oniice))*
- [`2ff01f6`](https://github.com/myerscode/utilities-bags/commit/2ff01f6c21db7f472ba229dac9760967dfbd4399) - **bag**: add reverse method *(commit by [@oniice](https://github.com/oniice))*
- [`1748277`](https://github.com/myerscode/utilities-bags/commit/174827738b7b3243b6a42b897068c18c33f1e010) - **bag**: add chunk method *(commit by [@oniice](https://github.com/oniice))*
- [`a273e62`](https://github.com/myerscode/utilities-bags/commit/a273e62e9d18a662fe2b2fd62ed54e9d065d68f7) - **bag**: add pipe method *(commit by [@oniice](https://github.com/oniice))*

### Bug Fixes
- [`ae19939`](https://github.com/myerscode/utilities-bags/commit/ae1993991ccc34521c130086f768dadf4b6a8226) - **dead-code**: fix missing return and rename test *(commit by [@oniice](https://github.com/oniice))*

### Refactors
- [`cc2ad86`](https://github.com/myerscode/utilities-bags/commit/cc2ad86871d0172d0098472c090f3e1c1d73121f) - **rector**: apply Rector modernisation rules *(commit by [@oniice](https://github.com/oniice))*
- [`a255669`](https://github.com/myerscode/utilities-bags/commit/a2556692c2e1b9018e247b2d03846f0f6ebb8b00) - **php**: modernise codebase for PHP 8.5 *(commit by [@oniice](https://github.com/oniice))*
- [`e2328f8`](https://github.com/myerscode/utilities-bags/commit/e2328f83e513e1659591907549fc13c6ac11b3cb) - **rector**: modernise codebase *(commit by [@oniice](https://github.com/oniice))*
- [`9cf4e01`](https://github.com/myerscode/utilities-bags/commit/9cf4e01a8ca0c1bce20e09aea35e81623b650677) - **php**: use PHP 8.5 features *(commit by [@oniice](https://github.com/oniice))*

### Tests
- [`c0d4501`](https://github.com/myerscode/utilities-bags/commit/c0d45016cfcdc0f7a8b0e9202dd3ce6ce51da6e9) - **coverage**: improve coverage with data providers *(commit by [@oniice](https://github.com/oniice))*
- [`ec63be4`](https://github.com/myerscode/utilities-bags/commit/ec63be42d4d1bd5ef731675f1ad29472b9ddece2) - **bags**: rename test methods to camelCase *(commit by [@oniice](https://github.com/oniice))*
- [`0bbb77e`](https://github.com/myerscode/utilities-bags/commit/0bbb77e85dfef642397ffe0d401f6e645e6aec99) - **bag**: add edge case coverage *(commit by [@oniice](https://github.com/oniice))*
- [`75b4598`](https://github.com/myerscode/utilities-bags/commit/75b4598cf577c7c0fe8955eb3c468a86f168aac0) - **coverage**: achieve 100% Utility coverage *(commit by [@oniice](https://github.com/oniice))*


## [2025.1.0](https://github.com/myerscode/utilities-bags/releases/tag/2025.1.0) - 2025-02-16

- [`4c8ac09`](https://github.com/myerscode/utilities-bags/commit/4c8ac09226e16086b3853ea066779097a5be839e) chore(github): updated badges
- [`4b46efa`](https://github.com/myerscode/utilities-bags/commit/4b46efac47c34bd640c768bc2beb5f7f7ef9f63f) fix(phpunit): updated config to remove deprecated options
- [`d38cf25`](https://github.com/myerscode/utilities-bags/commit/d38cf25aaaadee5703b3a1be7ecf31d2b8a58d25) feat(core): accept empty bag to build utility
- [`3003bd7`](https://github.com/myerscode/utilities-bags/commit/3003bd7119763068950992f930125394ca2c77a3) feat(core): added global helper
- [`316fcd0`](https://github.com/myerscode/utilities-bags/commit/316fcd0400d07fb7d438705f5248476e9caadbdb) chore(core): added linting and tidied up files
- [`328d151`](https://github.com/myerscode/utilities-bags/commit/328d15145bf1edc3c41830d1e19999da5b1cfe4a) chore(core): tidy up docblocks
- [`38dcd05`](https://github.com/myerscode/utilities-bags/commit/38dcd0549fe5d60b248a9be2a98d98df4638cd4f) chore(core): removed unused phpcs
- [`b8cc335`](https://github.com/myerscode/utilities-bags/commit/b8cc3350a90ca074a470b9848a67aee340bf7d6d) ci(uplift): uplifted for version 2025.0.0
- [`1a7b80f`](https://github.com/myerscode/utilities-bags/commit/1a7b80fde0fac5b5db3a68d1c0f1aae0b4b7aa38) chore(core): more updates for php 84

## [2025.0.0](https://github.com/myerscode/utilities-bags/releases/tag/2025.0.0) - 2025-02-02

- [`4479b77`](https://github.com/myerscode/utilities-bags/commit/4479b7714d0fe848aacce7a4a72cdc47492fe82b) chore(core): added changelog
- [`5796922`](https://github.com/myerscode/utilities-bags/commit/5796922ed764ac50b0e9c47baed616e5ba8a79c9) chore(core): updated codebase and dependancies for 2025 release

## [2.2.0](https://github.com/myerscode/utilities-bags/releases/tag/2.2.0) - 2023-10-31

- [`c3738f6`](https://github.com/myerscode/utilities-bags/commit/c3738f672c874932ff078245d40ccc5f94428884) Merge branch 'release/2.2.0'
- [`0920912`](https://github.com/myerscode/utilities-bags/commit/092091276115ee222f42125786897a9978a5770a) docs: added missing except and only methods
- [`f49dfa9`](https://github.com/myerscode/utilities-bags/commit/f49dfa9ec72435832752dd7979811f0348971452) docs: updated header formatting of methods
- [`7ca41ae`](https://github.com/myerscode/utilities-bags/commit/7ca41aea08a025c455e66159c089cffa849f8d73) test: run github actions against newer versions of php8
- [`d36f60b`](https://github.com/myerscode/utilities-bags/commit/d36f60b303903a2046dae3e4bf2ab871de1bc28d) feat: added method for getting bag with only the given keys
- [`95cfd69`](https://github.com/myerscode/utilities-bags/commit/95cfd698eebd235469275fe0717303b30f8991af) feat: added method for getting bag exluding given keys
- [`440d2a3`](https://github.com/myerscode/utilities-bags/commit/440d2a3c0ed34e87b1de60128cacf4b8c2a2f9ef) Merge branch 'release/2.1.0'
[2026.0.0]: https://github.com/myerscode/utilities-bags/compare/2025.1.0...2026.0.0
[2026.0.0]: https://github.com/myerscode/utilities-bags/compare/2025.1.0...2026.0.0
