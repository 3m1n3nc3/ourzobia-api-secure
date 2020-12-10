<?php

use \PhpImap\Mailbox;
 
if (! function_usable('folder_icon'))
{
    function folder_icon(string $folder) 
    { 
        switch (strtolower($folder)) {
            case 'inbox':
                return 'fas fa-inbox';
                break;
            
            case 'drafts':
                return 'far fa-file-alt';
                break;
            
            case 'junk':
                return 'fas fa-filter';
                break;
            
            case 'trash':
                return 'fas fa-trash-alt';
                break;
            

            default:
                return 'far fa-envelope';
                break;
        }
    }
}
 

if (! function_usable('base64_url'))
{
    function base64_url(string $url, $action = 'encode') 
    { 
        switch ($action) {
            case 'decode':
                return urldecode(base64_decode($url));
                break; 

            default:
                return urlencode(base64_encode($url));
                break;
        }
    }
}
 

if (! function_usable('folder_name'))
{
    function folder_name(string $folder = null, $lowercase = false) 
    { 
        $imapPathParts = \explode('}', $folder);
        $mailboxFolder = (!empty($imapPathParts[1])) ? $imapPathParts[1] : 'INBOX';
        $mailboxFolder = \explode('.', $mailboxFolder);
        $mailboxFolder = (!empty($mailboxFolder[1])) ? $mailboxFolder[1] : $mailboxFolder[0];

        if ($lowercase === true) 
        {
            return strtolower($mailboxFolder);
        }

        return $mailboxFolder;
    }
}
 

if (! function_usable('mail_draft'))
{

    // TYPEMESSAGE;
    // TYPEMULTIPART;
    // TYPETEXT;
    function mail_draft(string $to, $subject = '', $message = '') 
    {  
        $envelope["subject"] = $subject;
        $envelope["from"]    = "support@toneflix.com.ng";
        $envelope["to"]      = $to; 

        $mail_part1["type"]          = TYPEMESSAGE;
        $mail_part1["subtype"]       = "plain";
        $mail_part1["description"]   = strtolower($message);
        $mail_part1["contents.data"] = "$message \n\n\n\t";

        $body[1] = $mail_part1; 

        return [
            $envelope,
            $body
        ];
    }
}