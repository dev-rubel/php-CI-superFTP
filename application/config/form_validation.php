<?php 

$config = [
    'ftpAccount' => [
        [
            'field' => 'ftpName',
            'label' => 'FTP Name',
            'rules' => 'required|is_unique[ftp_ftpaccounts.ftpName]'
        ],
        [
            'field' => 'ftpHost',
            'label' => 'Host',
            'rules' => 'required'
        ],
        [
            'field' => 'ftpUser',
            'label' => 'User Name',
            'rules' => 'required'
        ],
        [
            'field' => 'ftpPassword',
            'label' => 'Password',
            'rules' => 'required'
        ],
        [
            'field' => 'ftpPath',
            'label' => 'Location Path',
            'rules' => 'required'
        ],
        [
            'field' => 'ftpPort',
            'label' => 'Port',
            'rules' => 'required'
        ]
    ],
    'ftpAccount2' => [
        [
            'field' => 'ftpName',
            'label' => 'FTP Name',
            'rules' => 'required'
        ],
        [
            'field' => 'ftpHost',
            'label' => 'Host',
            'rules' => 'required'
        ],
        [
            'field' => 'ftpUser',
            'label' => 'User Name',
            'rules' => 'required'
        ],
        [
            'field' => 'ftpPassword',
            'label' => 'Password',
            'rules' => 'required'
        ],
        [
            'field' => 'ftpPath',
            'label' => 'Location Path',
            'rules' => 'required'
        ],
        [
            'field' => 'ftpPort',
            'label' => 'Port',
            'rules' => 'required'
        ]
    ],
    'ftpUserAdminAccount' => [
        [
            'field' => 'userFullName',
            'label' => 'Full Name',
            'rules' => 'required'
        ],
        [
            'field' => 'userName',
            'label' => 'User Name',
            'rules' => 'required|is_unique[ftp_users.userName]'
        ],
        [
            'field' => 'userEmail',
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[ftp_users.userEmail]'
        ],
        [
            'field' => 'userPassword',
            'label' => 'Password',
            'rules' => 'required'
        ],
        [
            'field' => 'userDesignation',
            'label' => 'Designation',
            'rules' => 'required'
        ]
    ],
    'ftpUserUserAccount' => [
        [
            'field' => 'userFullName',
            'label' => 'Full Name',
            'rules' => 'required'
        ],
        [
            'field' => 'userName',
            'label' => 'User Name',
            'rules' => 'required|is_unique[ftp_users.userName]'
        ],
        [
            'field' => 'userEmail',
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[ftp_users.userEmail]'
        ],
        [
            'field' => 'userPassword',
            'label' => 'Password',
            'rules' => 'required'
        ],
        [
            'field' => 'userDesignation',
            'label' => 'Designation',
            'rules' => 'required'
        ],
        [
            'field' => 'userFtpAccess[]',
            'label' => 'FTP Access',
            'rules' => 'required'
        ],
        [
            'field' => 'userFtpFileAccess[]',
            'label' => 'FTP File Access',
            'rules' => 'required'
        ]
    ],
    'ftpUserUpdateAccountWithoutPassword' => [
        [
            'field' => 'userFullName',
            'label' => 'Full Name',
            'rules' => 'required'
        ]
    ],
    'ftpUserUpdateAccountWithPassword' => [
        [
            'field' => 'userFullName',
            'label' => 'Full Name',
            'rules' => 'required'
        ],
        [
            'field' => 'userOldPassword',
            'label' => 'Old Password',
            'rules' => 'trim|required|callback_oldpassword_check'
        ],
        [
            'field' => 'userConfPassword',
            'label' => 'Confirm Password',
            'rules' => 'trim|required|matches[userNewPassword]'
        ],
        [
            'field' => 'userNewPassword',
            'label' => 'New Password',
            'rules' => 'trim|required'
        ]
        
    ]

];