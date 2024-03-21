<?php
class Contact {
    public $name;
    public $phone; 
    public $address;
    public $email;

    public function __construct($name, $phone, $address, $email) {
      $this->name = $name;
      $this->phone = $phone;
      $this->address = $address;
      $this->email = $email;
    }
}

class ContactsManager {
    private $contacts = [];
    private $currentIndex = 0;

    public function loadContacts() {
      $xml = simplexml_load_file('contacts.xml');
      foreach ($xml->contact as $contact) {
        $this->contacts[] = new Contact (
          (string)$contact->name,
          (string)$contact->phone,
          (string)$contact->address,
          (string)$contact->email,
        );
      }
    }

    public function saveContacts()
    {
        $xml = new SimpleXMLElement('<contacts></contacts>');
        foreach ($this->contacts as $contact) {
            $xmlContact = $xml->addChild('contact');
            $xmlContact->addChild('name', $contact->name);
            $xmlContact->addChild('phone', $contact->phone);
            $xmlContact->addChild('address', $contact->address);
            $xmlContact->addChild('email', $contact->email);
        }
        $xml->asXML('contacts.xml');
    }

    public function insertContact($name, $phone, $address, $email)
    {
        $this->contacts[] = new Contact($name, $phone, $address, $email);
        $this->saveContacts();
    }

    public function updateContact($name, $phone, $address, $email)
    {
        foreach ($this->contacts as $contact) {
            if ($contact->name == $name) {
                $contact->phone = $phone;
                $contact->address = $address;
                $contact->email = $email;
                break;
            }
        }
        $this->saveContacts();
    }

    public function deleteContact($name)
    {
        foreach ($this->contacts as $key => $contact) {
            if ($contact->name == $name) {
                unset($this->contacts[$key]);
                break;
            }
        }
        $this->saveContacts();
    }

    public function searchContact($name)
    {
        $result = [];
        foreach ($this->contacts as $contact) {
            if ($contact->name == $name) {
                $result[] = [
                    'name' => $contact->name,
                    'phone' => $contact->phone,
                    'address' => $contact->address,
                    'email' => $contact->email
                ];
            }
        }
        return $result;
    }

    public function getCurrentContact()
    {
        if (isset($this->contacts[$this->currentIndex])) {
            return $this->contacts[$this->currentIndex];
        } else {
            return null;
        }
    }

    public function nextContact()
    {
        $this->currentIndex++;
        if ($this->currentIndex >= count($this->contacts)) {
            $this->currentIndex = 0;
        }
        return $this->contacts[$this->currentIndex];
    }

    public function prevContact()
    {
        $this->currentIndex--;
        if ($this->currentIndex < 0) {
            $this->currentIndex = count($this->contacts) - 1;
        }
        return $this->contacts[$this->currentIndex];
    }
}

$contactsManager = new ContactsManager();
$contactsManager->loadContacts();

$name = '';
$phone = '';
$email = '';
$address = '';
$currentContact = $contactsManager->getCurrentContact();

if ($currentContact) {
  $name = $currentContact->name;
  $phone = $currentContact->phone;
  $email = $currentContact->email;
  $address = $currentContact->address;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['insert'])) {
      $contactsManager->insertContact($_POST['name'], $_POST['phone'], $_POST['address'], $_POST['email']);
    } elseif (isset($_POST['update'])) {
      $contactsManager->updateContact($_POST['name'], $_POST['phone'], $_POST['address'], $_POST['email']);
    } elseif (isset($_POST['delete'])) {
      $contactsManager->deleteContact($_POST['name']);
    } elseif (isset($_POST['search'])) {
      $searchResult = $contactsManager->searchContact($_POST['name']);
      if (!empty($searchResults)) {
        $name = $searchResults[0]['name'];
        $phone = $searchResults[0]['phone'];
        $email = $searchResults[0]['email'];
        $address = $searchResults[0]['address'];
      }
    } elseif (isset($_POST['next'])) {
      $nextContact = $contactsManager->nextContact();
      if($nextContact) {
        $name = $nextContact->name;
        $phone = $nextContact->phone;
        $email = $nextContact->email;
        $address = $nextContact->address;
      }
    } elseif (isset($_POST['prev'])) {
      $prevContact = $contactsManager->prevContact();
      if($prevContact) {

      }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form method="post">
    <div class="inputs-container">
      <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $name?>">
      </div>

      <div>
        <label for="phone">Phone:</label>
        <input type="number" name="phone" id="phone" value="<?php echo $phone?>">
      </div>

      <div>
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="<?php echo $address?>">
      </div>

      <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $email?>">
      </div>
    </div>

    <div class="btns-container">
      <input type="submit" name="insert" value="Insert">
      <input type="submit" name="update" value="Update">
      <input type="submit" name="delete" value="Delete">
      <input type="submit" name="search" value="Search By Name">
      <input type="submit" name="prev" value="Prev">
      <input type="submit" name="next" value="Next">

    </div>
  </form>
</body>

</html>