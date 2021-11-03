# Exchange testing

# 執行方法

### 使用 Codeigniter

###### 假設已建立好 codeigniter & postman 環境

    {{protocol}}://{{api_domain}}:{{api_port}}/{{path}}/trans?source=USD&target=TWD&money=100

    Body/raw 資料：
    {
      "currencies": {
        "TWD": {
          "TWD": 1,
          "JPY": 3.669,
          "USD": 0.03281
        },
        "JPY": {
          "TWD": 0.26956,
          "JPY": 1,
          "USD": 0.00885
        },
        "USD": {
          "TWD": 30.444,
          "JPY": 111.801,
          "USD": 1
        }
      }
    }

# 預期結果
### 正常資料回應
    {
        "error": {
            "code": "0",
            "message": ""
        },
        "data": {
            "source": "USD",
            "target": "TWD",
            "money": "100.00",
            "exchanged": "3,044.40"
        }
    }
    
### 輸入錯誤回應
    {
        "error": {
            "code": "4000",
            "message": "Invalid parameter"
        },
        "data": {}
    }

    {
        "error": {
            "code": "4001",
            "message": "Unknown currency"
        },
        "data": {}
    }

    {
        "error": {
            "code": "4002",
            "message": "Money have to be number"
        },
        "data": {}
    }
