BX24.callMethod(
    "crm.activity.list",
    {
        order:{ "ID": "DESC" },
        filter:
            {
                "OWNER_TYPE_ID": 2,
                "OWNER_ID": 10
            },
        select:[ "*", "COMMUNICATIONS" ]
    },
    function(result)
    {
        if(result.error())
            console.error(result.error());
        else
        {
            alert('good');
            console.dir(result.data());
            if(result.more())
                result.next();
        }
    }
);