import { Button } from "@/components/ui/button";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { useForm } from "@inertiajs/react";

type CreateSpaceDialogProps = {
    open: boolean;
    onOpenChange: (open: boolean) => void;
};

function CreateSpaceDialog(props: CreateSpaceDialogProps) {
    const form = useForm({ name: "", type: "team" });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        form.post("/api/space", {
            preserveState: true,
            onSuccess: () => {
                props.onOpenChange(false);
            },
        });
    };

    return (
        <Dialog open={props.open} onOpenChange={props.onOpenChange}>
            <DialogContent data-dusk="create-space-dialog" className="sm:max-w-[425px]">
                <Form {...form}>
                    <form onSubmit={handleSubmit}>
                        <DialogHeader>
                            <DialogTitle>Create Space</DialogTitle>
                            <DialogDescription>
                                Organize your task by spaces
                            </DialogDescription>
                        </DialogHeader>
                        <FormField
                            data={form.data}
                            name="name"
                            render={({ field, setValue }) => (
                                <FormItem>
                                    <FormLabel htmlFor={field.id}></FormLabel>
                                    <FormControl>
                                        <Input
                                            data-dusk="create-space-dialog-name"
                                            {...field}
                                            onChange={(e) => setValue(e.target.value)}
                                        />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            )}
                        />
                        <DialogFooter className="mt-4">
                            <Button
                                data-dusk="create-space-dialog-create"
                                type="submit"
                                disabled={form.processing}>
                                {form.processing ? "Creating ..." : "Create"}
                            </Button>
                        </DialogFooter>
                    </form>
                </Form>
            </DialogContent>
        </Dialog>
    );
}

export { CreateSpaceDialog };

export default CreateSpaceDialog;
