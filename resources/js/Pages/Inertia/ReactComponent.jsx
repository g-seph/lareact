import {Head} from '@inertiajs/react';

export default function ReactComponent({message, user}) {
    console.log("HELLO");
    return (
        <>
            <Head title="Welcome"/>
            <h1>Welcome</h1>
            <p>Hello {user?.name}, welcome to your first Inertia app!</p>
            <p>Here's a message from the Laravel server: "{message}"</p>
        </>
    )
}
