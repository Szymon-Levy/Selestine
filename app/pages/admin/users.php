<h2>Users</h2>

<table>
  <thead>
    <th>Id</th>
    <th>Avatar</th>
    <th>Username</th>
    <th>Email</th>
    <th>Date</th>
    <th>Account type</th>
  </thead>

  <?php
    $all_users_query = 'SELECT * FROM users ORDER BY id ASC';
    $found_users = query($pdo, $all_users_query);
  ?>

  <?php if (!empty($found_users)) { ?>
  <tbody>
    <?php foreach($found_users as $user) { ?>

      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= $user['avatar'] ?></td>
        <td><?= $user['user_name'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['create_date'] ?></td>
        <td><?= $user['account_type'] ?></td>
      </tr>

    <?php } ?>
  </tbody>
  <?php } ?>
</table>