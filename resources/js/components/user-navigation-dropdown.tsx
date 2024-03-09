import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { getInitials } from "@/lib/utils";
import { Link } from "@inertiajs/react";

type UserProfileProps = {
    name: string;
};

function UserNavigationDropdown(props: UserProfileProps) {
    const initials = getInitials(props.name);
    return (
        <DropdownMenu>
            <DropdownMenuTrigger
                data-dusk="user-nav-trigger"
                className="flex items-center w-full max-w-max">
                <>
                    <Avatar className="mr-2">
                        <AvatarFallback>{initials}</AvatarFallback>
                    </Avatar>
                    <span data-dusk="user-nav-user">{props.name}</span>
                </>
            </DropdownMenuTrigger>
            <DropdownMenuContent>
                <DropdownMenuItem asChild>
                    <Link
                        data-dusk="user-nav-item-logout"
                        className="cursor-pointer"
                        href="/api/auth/signout"
                        method="post">
                        Log out
                    </Link>
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    );
}

export { UserNavigationDropdown };
