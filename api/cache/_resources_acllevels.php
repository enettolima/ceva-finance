<?php return '{"apiVersion":"1","swaggerVersion":"1.1","basePath":"http:\\/\\/localhost:8888\\/api","apis":[{"path":"\\/acllevels\\/byID\\/{id}","description":"All methods in this class are protected","operations":[{"httpMethod":"GET","nickname":"byID","responseClass":"Array","parameters":[{"name":"id","description":"AclLevels to be fetched.","paramType":"path","required":true,"allowMultiple":false,"dataType":"int"}],"summary":"Method to fecth AclLevels Record by ID&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Fech a record for a specific acl_levels by ID","errorResponses":[{"reason":"User not found for requested id","code":404}]}]},{"path":"\\/acllevels\\/delete","description":"All methods in this class are protected","operations":[{"httpMethod":"GET","nickname":"remove","responseClass":"Array","parameters":[],"summary":"Method to delete a acl_levels&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Delete acl_levels from database","errorResponses":[{"reason":"AclLevels not found","code":404}]}]},{"path":"\\/acllevels\\/loadAll","description":"All methods in this class are protected","operations":[{"httpMethod":"GET","nickname":"loadAll","responseClass":"Array","parameters":[],"summary":"Method to fecth All AclLevelss&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Fech all records from the database","errorResponses":[{"reason":"AclLevels not found","code":404}]}]},{"path":"\\/acllevels\\/put","description":"All methods in this class are protected","operations":[{"httpMethod":"GET","nickname":"update","responseClass":"Array","parameters":[],"summary":"Method to Update acl_levels information&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Update acl_levels on database","errorResponses":[{"reason":"AclLevels not found","code":404}]}]},{"path":"\\/acllevels\\/byID","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"byID_","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here with the following property.<hr\\/>id : <tag>int<\\/tag>  <i>(required)<\\/i> - AclLevels to be fetched.","required":true,"defaultValue":"{\\"id\\":\\"\\"}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to fecth AclLevels Record by ID&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Fech a record for a specific acl_levels by ID","errorResponses":[{"reason":"User not found for requested id","code":404}]}]},{"path":"\\/acllevels\\/create","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"create","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here","required":true,"defaultValue":"{\\n    \\"property\\" : \\"\\"\\n}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to create a new acl_levels&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Add a new acl_levels","errorResponses":[]}]},{"path":"\\/acllevels\\/delete","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"remove","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here","required":true,"defaultValue":"{\\n    \\"property\\" : \\"\\"\\n}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to delete a acl_levels&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Delete acl_levels from database","errorResponses":[{"reason":"AclLevels not found","code":404}]}]},{"path":"\\/acllevels\\/loadAll","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"loadAll","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here","required":true,"defaultValue":"{\\n    \\"property\\" : \\"\\"\\n}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to fecth All AclLevelss&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Fech all records from the database","errorResponses":[{"reason":"AclLevels not found","code":404}]}]},{"path":"\\/acllevels\\/put","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"update","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here","required":true,"defaultValue":"{\\n    \\"property\\" : \\"\\"\\n}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to Update acl_levels information&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Update acl_levels on database","errorResponses":[{"reason":"AclLevels not found","code":404}]}]}],"resourcePath":"\\/acllevels","models":{}}';