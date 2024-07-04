import Button from '@/Components/Button/Button.vue';
import { Meta, StoryObj } from '@storybook/vue3';

const meta: Meta<typeof Button> = {
    component: Button,
};
export default meta;

type Story = StoryObj<typeof Button>;

const Template = (args: object) => ({
    components: { Button },
    setup() {
        return { mode: 'danger', ...args };
    },
    template: '<Button v-bind="args">Test Button</Button>',
});

export const button = Template.bind({});
