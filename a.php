<?


class Role {
  private $name;
  private $permissions;

  public function __construct($name, $permissions) {
    $this->name = $name;
    $this->permissions = $permissions;
  }

  public function hasPermission($permission) {
    return in_array($permission, $this->permissions);
  }
}

class User {
  private $name;
  private $role;

  public function __construct($name, $role) {
    $this->name = $name;
    $this->role = $role;
  }

  public function hasPermission($permission) {
    return $this->role->hasPermission($permission);
  }
}

// Define roles
$adminRole = new Role("admin", ["create post", "edit post", "delete post", "create user", "edit user", "delete user"]);
$editorRole = new Role("editor", ["create post", "edit post", "delete post"]);
$authorRole = new Role("author", ["create post", "edit post"]);
$subscriberRole = new Role("subscriber", []);

// Define users
$user1 = new User("John", $adminRole);
$user2 = new User("Jane", $editorRole);
$user3 = new User("Bob", $authorRole);
$user4 = new User("Alice", $subscriberRole);

// Check permissions
echo $user1->hasPermission("create post"); // true
echo '<br>';
echo $user2->hasPermission("delete post"); // false
echo '<br>';
echo $user3->hasPermission("edit post"); // true
echo '<br>';
echo $user4->hasPermission("create post"); // false
echo '<br>';




?>