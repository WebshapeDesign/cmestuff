<flux:main container>
    <flux:heading size="lg">{{ isset($user) ? 'Edit User' : 'New User' }}</flux:heading>

    <form method="POST" action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="flex flex-col gap-4">
            <flux:input name="name" label="Name" value="{{ old('name', $user->name ?? '') }}" required />
            <flux:input name="email" label="Email" value="{{ old('email', $user->email ?? '') }}" required />
            <flux:input name="password" label="Password" type="password" />
            <flux:select name="role" label="Role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </flux:select>

            <flux:button type="submit" variant="primary">
                {{ isset($user) ? 'Update User' : 'Create User' }}
            </flux:button>
        </div>
    </form>
</flux:main>
