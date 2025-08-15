## [v1.1.0] - 2025-01-27

### Added
- New command system with `/onjoin` command
- Ability to set custom join messages with `/onjoin joinmessage <text>`
- Ability to set custom quit messages with `/onjoin quitmessage <text>`
- Message type configuration (message/tip) with `/onjoin settype <message/tip>`
- Configuration reload command `/onjoin reload`
- Help command `/onjoin help` to display all available commands
- Command aliases: `/oj` as shortcut for `/onjoin`

### Changed
- Improved plugin architecture with dedicated command handler
- Enhanced configuration management system
- Better error messages and user feedback

### Technical Improvements
- Implemented proper PluginOwned interface for commands
- Added type hints for better code reliability
- Improved configuration handling and validation

## [v1.0.0] - 2025-01-07

### Added
- Initial release of OnJoin plugin
- Basic join and quit message functionality
- Configuration file support for customizing messages
- Player name placeholder support with `{PLAYER}` tag
