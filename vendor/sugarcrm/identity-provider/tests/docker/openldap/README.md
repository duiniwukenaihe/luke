# Docker SP for test LDAP authentication

## Usage

### Build container
```
docker build --tag "identity-provider/ldapserver:<version>" .
```

### Push container to SugarCRM docker registry
```
docker tag identity-provider/ldapserver:<version> registry.sugarcrm.net/identity-provider/ldapserver:latest
docker push registry.sugarcrm.net/identity-provider/ldapserver:latest
```

#### Run from local build
```
docker run --name idm-ldap -p 389:389 -p 639:639 --hostname "openldap.com" -d identity-provider/ldapserver:<version>
```

#### Run from SugarCRM registry build
```
docker run --name idm-ldap -p 389:389 -p 639:639 --hostname "openldap.com" -d  registry.sugarcrm.net/identity-provider/ldapserver:latest
```

There are several users configured in the ldap server with the following data:

| UID | Username | Password | Group | DN |
|-----|----------|----------|-------|----|
| 1 | abey | abey | Administrators | cn=abey,ou=people,dc=openldap,dc=com |
| 2 | tandav | tandav | Administrators | cn=tandav,ou=people,dc=openldap,dc=com |
| 3 | user1 | user1 | Read Only, Group1 | cn=user1,ou=people,dc=openldap,dc=com |
| 4 | user2 | user2 | Read Only, Group2 | cn=user2,ou=people,dc=openldap,dc=com |
| 5 | user3 | user3 | Group2 | cn=user3,ou=people,dc=openldap,dc=com |
| 6 | user, comma | usercomma | Group1 | cn=user\, comma,ou=people,dc=openldap,dc=com |
| 7 | user1.comma | user1comma | Group1 | cn=user1\, comma,ou=people,dc=openldap,dc=com |


## IDM ldap sample config

### Config without group checking
```
$params['ldap']['adapter_config'] = [
    'host' => '127.0.0.1',
    'port' => 389,
];
$params['ldap']['adapter_connection_protocol_version'] = 3;
$params['ldap']['baseDn'] = 'dc=openldap,dc=com';
$params['ldap']['searchDn'] = 'cn=admin,ou=admins,dc=openldap,dc=com';
$params['ldap']['searchPassword'] = 'admin';
$params['ldap']['uidKey'] = 'uid';
$params['ldap']['filter'] = '({uid_key}={username})';
$params['ldap']['dnString'] = null;
$params['ldap']['entryAttribute'] = null;
$params['ldap']['groupMembership'] = false;
```

### Config with group checking
```
$params['ldap']['adapter_config'] = [
    'host' => '127.0.0.1',
    'port' => 389,
];
$params['ldap']['adapter_connection_protocol_version'] = 3;
$params['ldap']['baseDn'] = 'dc=openldap,dc=com';
$params['ldap']['searchDn'] = 'cn=admin,ou=admins,dc=openldap,dc=com';
$params['ldap']['searchPassword'] = 'admin';
$params['ldap']['uidKey'] = 'uid';
$params['ldap']['filter'] = '({uid_key}={username})';
$params['ldap']['dnString'] = null;
$params['ldap']['entryAttribute'] = null;
$params['ldap']['groupMembership'] = true;
$params['ldap']['groupDn'] = 'cn=Administrators,ou=groups,dc=openldap,dc=com';
$params['ldap']['userUniqueAttribute'] = null;
$params['ldap']['groupAttribute'] = 'member';
$params['ldap']['includeUserDN'] = false;
```

## SugarCRM ldap sample settings

### Settings without group checking

| Form field | Form value |
|------------|------------|
| Enable LDAP Authentication | checked |
| Server | 127.0.0.1 |
| Port Number | 389 |
| User DN | dc=openldap,dc=com |
| User Filter | |
| Bind Attribute | |
| Login Attribute | uid |
| Group Membership | unchecked |
| Authentication | checked |
| User Name | cn=admin,ou=admins,dc=openldap,dc=com |
| Password | admin |

### Settings with group checking

| Form field | Form value |
|------------|------------|
| Enable LDAP Authentication | checked |
| Server | 127.0.0.1 |
| Port Number | 389 |
| User DN | dc=openldap,dc=com |
| User Filter | |
| Bind Attribute | |
| Login Attribute | uid |
| Group Membership | unchecked |
| Authentication | checked |
| User Name | cn=admin,ou=admins,dc=openldap,dc=com |
| Group Membership | checked |
| Group DN | ou=groups,dc=openldap,dc=com |
| Group Name | cn=Administrators |
| Group Attribute | member |
