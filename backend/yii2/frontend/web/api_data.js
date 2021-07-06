define({ "api": [
  {
    "type": "post",
    "url": "/site/upload-image",
    "title": "",
    "description": "<p>上传图片</p>",
    "group": "公共",
    "name": "上传图片",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "source",
            "defaultValue": "APP",
            "description": "<p>请求头必须携带来源字段</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "image",
            "description": "<p>图片</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "examples": [
      {
        "title": "访问示例：",
        "content": "curl -i http://127.0.0.1:8888/site/upload-image",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>错误信息</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>0 报错 2 提醒</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "error-example",
          "content": "{\n\"code\": 2,\n\"message\": \"请填写手机号\",\n\"data\": null,\n\"duration\": 78\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "defaultValue": "1",
            "description": "<p>成功</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>提示语</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data",
            "description": "<p>上传成功的id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "success-example",
          "content": "{\n\"code\": 1,\n\"message\": \"上传成功\",\n\"data\": 2,\n\"duration\": 269\n}",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/controllers/SiteController.php",
    "groupTitle": "公共"
  },
  {
    "type": "post",
    "url": "/site/image",
    "title": "",
    "description": "<p>查看图片</p>",
    "group": "公共",
    "name": "查看图片",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>上传图片的id</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "examples": [
      {
        "title": "访问示例：",
        "content": "curl -i http://127.0.0.1:8888/site/image",
        "type": "curl"
      }
    ],
    "filename": "frontend/controllers/SiteController.php",
    "groupTitle": "公共"
  },
  {
    "type": "post",
    "url": "/site/register",
    "title": "",
    "description": "<p>用户注册</p>",
    "group": "用户",
    "name": "注册",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "source",
            "defaultValue": "APP",
            "description": "<p>请求头必须携带来源字段</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gender",
            "description": "<p>性别:1男2女</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "examples": [
      {
        "title": "访问示例：",
        "content": "curl -i http://127.0.0.1:8888/site/register",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>错误信息</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>0 报错 2 提醒</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "error-example",
          "content": "{\n\"code\": 2,\n\"message\": \"请填写手机号\",\n\"data\": null,\n\"duration\": 78\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>1 成功</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>提示语</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data",
            "description": "<p>注册成功返回的的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "success-example",
          "content": "{\n\"code\": 1,\n\"message\": \"注册成功\",\n\"data\": \"aUNJMjhZOUdQdHZOSFJ2S3FBWlFWMnlKN2p2QU9rS0s6JjoxNjI2Mzk5NzI3OiY6Mw==\",\n\"duration\": 697\n}",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/controllers/SiteController.php",
    "groupTitle": "用户"
  },
  {
    "type": "post",
    "url": "/site/login",
    "title": "",
    "description": "<p>登陆获取用户token</p>",
    "group": "用户",
    "name": "登陆",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "source",
            "defaultValue": "APP",
            "description": "<p>请求头必须携带来源字段</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "examples": [
      {
        "title": "访问示例：",
        "content": "curl -i http://127.0.0.1:8888/site/login",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>错误信息</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>0 报错 2 提醒</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "error-example",
          "content": "{\n\"code\": 2,\n\"message\": \"请填写手机号\",\n\"data\": null,\n\"duration\": 78\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "code",
            "description": "<p>1 成功</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>提示语</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data",
            "description": "<p>登陆成功的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "success-example",
          "content": "{\n\"code\": 1,\n\"message\": \"登陆成功\",\n\"data\": \"VE1lTk05NnpLZktwRDdURGpOWVZNSzNnQ3gxZElWcjc6JjoxNjI2Mzk4NjM3OiY6MQ==\",\n\"duration\": 742\n}",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/controllers/SiteController.php",
    "groupTitle": "用户"
  }
] });
