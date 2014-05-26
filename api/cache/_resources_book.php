<?php return '{"apiVersion":"1","swaggerVersion":"1.1","basePath":"http:\\/\\/localhost:8888\\/api","apis":[{"path":"\\/book\\/byID\\/{id}","description":"All methods in this class are protected","operations":[{"httpMethod":"GET","nickname":"byID","responseClass":"Array","parameters":[{"name":"id","description":"Book to be fetched.","paramType":"path","required":true,"allowMultiple":false,"dataType":"int"}],"summary":"Method to fecth Book Record by ID&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Fech a record for a specific book by ID","errorResponses":[{"reason":"User not found for requested id","code":404}]}]},{"path":"\\/book\\/delete","description":"All methods in this class are protected","operations":[{"httpMethod":"GET","nickname":"remove","responseClass":"Array","parameters":[],"summary":"Method to delete a book&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Delete book from database","errorResponses":[{"reason":"Book not found","code":404}]}]},{"path":"\\/book\\/loadAll","description":"All methods in this class are protected","operations":[{"httpMethod":"GET","nickname":"loadAll","responseClass":"Array","parameters":[],"summary":"Method to fecth All Books&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Fech all records from the database","errorResponses":[{"reason":"Book not found","code":404}]}]},{"path":"\\/book\\/put","description":"All methods in this class are protected","operations":[{"httpMethod":"GET","nickname":"update","responseClass":"Array","parameters":[],"summary":"Method to Update book information&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Update book on database","errorResponses":[{"reason":"Book not found","code":404}]}]},{"path":"\\/book\\/byID","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"byID_","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here with the following property.<hr\\/>id : <tag>int<\\/tag>  <i>(required)<\\/i> - Book to be fetched.","required":true,"defaultValue":"{\\"id\\":\\"\\"}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to fecth Book Record by ID&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Fech a record for a specific book by ID","errorResponses":[{"reason":"User not found for requested id","code":404}]}]},{"path":"\\/book\\/create","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"create","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here","required":true,"defaultValue":"{\\n    \\"property\\" : \\"\\"\\n}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to create a new book&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Add a new book","errorResponses":[]}]},{"path":"\\/book\\/delete","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"remove","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here","required":true,"defaultValue":"{\\n    \\"property\\" : \\"\\"\\n}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to delete a book&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Delete book from database","errorResponses":[{"reason":"Book not found","code":404}]}]},{"path":"\\/book\\/loadAll","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"loadAll","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here","required":true,"defaultValue":"{\\n    \\"property\\" : \\"\\"\\n}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to fecth All Books&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Fech all records from the database","errorResponses":[{"reason":"Book not found","code":404}]}]},{"path":"\\/book\\/put","description":"All methods in this class are protected","operations":[{"httpMethod":"POST","nickname":"update","responseClass":"Array","parameters":[{"name":"REQUEST_BODY","description":"Paste JSON data here","required":true,"defaultValue":"{\\n    \\"property\\" : \\"\\"\\n}","paramType":"body","allowMultiple":false,"dataType":"Object"}],"summary":"Method to Update book information&nbsp; <i class=\\"icon-unlock-alt icon-large\\"><\\/i>","notes":"Update book on database","errorResponses":[{"reason":"Book not found","code":404}]}]}],"resourcePath":"\\/book","models":{}}';