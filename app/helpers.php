<?php

function gravatar_url($user)
{
    return 'https://s.gravatar.com/avatar/' . md5($user->email) . '?s=60&d=https://api.adorable.io/avatars/60/' . md5($user->name);
}
