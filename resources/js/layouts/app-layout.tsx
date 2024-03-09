import { SpaceSelect } from "@/components/space-select";
import { UserNavigationDropdown } from "@/components/user-navigation-dropdown";
import { useSpace } from "@/hooks/use-space";
import { PageProps, Space } from "@/types";
import { Link, router, usePage, useRemember } from "@inertiajs/react";
import { MixIcon } from "@radix-ui/react-icons";
import * as React from "react";

const CreateSpaceDialog = React.lazy(() => import("@/components/create-space-dialog"));

type Props = {
    space: Space;
};

function AppLayout(props: React.PropsWithChildren) {
    const {
        props: { whoami, space },
    } = usePage<PageProps<Props>>();
    const { personalSpace, teamSpaces, selectedSpace, setSelectedSpace } =
        useSpace(space);
    const [createSpaceDialogIsOpen, setCreateSpaceDialogIsOpen] = useRemember<boolean>(
        false,
        "create-space-dialog-is-open",
    );

    const handleOnSpaceSelected = (id: string) => {
        setSelectedSpace(id);
        router.replace(`/space/${id}`, {
            preserveState: true,
        });
    };
    const handleOnCreateNewSpace = () => setCreateSpaceDialogIsOpen(true);
    const handleOnOpenChange = (state: boolean) => setCreateSpaceDialogIsOpen(state);

    return (
        <>
            <div className="flex flex-col w-full h-full">
                <div className="flex items-center justify-between h-16 w-full px-8 border-b">
                    <div className="flex w-full items-center mr-auto">
                        <Link
                            data-dusk="nav-home"
                            href="/space"
                            className="flex items-center text-xl mr-4">
                            <MixIcon className="mr-2 h-5 w-5"></MixIcon>
                            Task
                        </Link>
                        <div className="w-52">
                            <SpaceSelect
                                selectedSpace={selectedSpace}
                                personal={personalSpace}
                                team={teamSpaces}
                                onSpaceSelected={handleOnSpaceSelected}
                                onCreateNewSpace={handleOnCreateNewSpace}
                            />
                        </div>
                    </div>
                    <UserNavigationDropdown name={whoami.name} />
                </div>
            </div>
            <React.Suspense>
                {createSpaceDialogIsOpen && (
                    <CreateSpaceDialog
                        open={createSpaceDialogIsOpen}
                        onOpenChange={handleOnOpenChange}
                    />
                )}
            </React.Suspense>
            <div className="px-8 py-4">{props.children}</div>
        </>
    );
}

export { AppLayout };
