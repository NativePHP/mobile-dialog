## nativephp/dialog

Native alert dialogs and toast notifications for NativePHP Mobile applications.

### PHP Usage (Livewire/Blade)

@verbatim
<code-snippet name="Alert Dialogs" lang="php">
use Native\Mobile\Facades\Dialog;

// Simple alert with custom buttons (max 3)
Dialog::alert(
    'Confirm Action',
    'Are you sure you want to delete this item?',
    ['Cancel', 'Delete']
);
</code-snippet>
@endverbatim

@verbatim
<code-snippet name="Toast Notifications" lang="php">
use Native\Mobile\Facades\Dialog;

// Display a brief toast notification
Dialog::toast('Item saved successfully!');
</code-snippet>
@endverbatim

### JavaScript Usage (Vue/React/Inertia)

@verbatim
<code-snippet name="Dialogs in JavaScript" lang="javascript">
import { dialog, on, off, Events } from '#nativephp';

// Simple alert
await dialog.alert('Confirm Action', 'Are you sure?', ['Cancel', 'Delete']);

// Fluent builder API
await dialog.alert()
    .title('Confirm Action')
    .message('Are you sure you want to delete this item?')
    .buttons(['Cancel', 'Delete']);

// Quick confirm dialog
await dialog.alert().confirm('Confirm Action', 'Are you sure?');

// Toast notification
await dialog.toast('Item saved successfully!');
</code-snippet>
@endverbatim

### Handling Alert Events

#### PHP

@verbatim
<code-snippet name="Button Press Events" lang="php">
use Native\Mobile\Attributes\OnNative;
use Native\Mobile\Events\Alert\ButtonPressed;

#[OnNative(ButtonPressed::class)]
public function handleAlertButton($index, $label)
{
    switch ($index) {
        case 0:
            Dialog::toast("You pressed '{$label}'");
            break;
        case 1:
            $this->performAction();
            Dialog::toast("You pressed '{$label}'");
            break;
    }
}
</code-snippet>
@endverbatim

#### Vue

@verbatim
<code-snippet name="Button Press Events in Vue" lang="javascript">
import { dialog, on, off, Events } from '#nativephp';
import { onMounted, onUnmounted } from 'vue';

const handleButtonPressed = (payload) => {
    const { index, label } = payload;
    if (index === 1) {
        performAction();
    }
    dialog.toast(`You pressed '${label}'`);
};

onMounted(() => {
    on(Events.Alert.ButtonPressed, handleButtonPressed);
});

onUnmounted(() => {
    off(Events.Alert.ButtonPressed, handleButtonPressed);
});
</code-snippet>
@endverbatim

### Button Positioning

- 1 button: Positive (OK/Confirm)
- 2 buttons: Negative (Cancel) + Positive (OK/Confirm)
- 3 buttons: Negative (Cancel) + Neutral (Maybe) + Positive (OK/Confirm)

### Events

- `Native\Mobile\Events\Alert\ButtonPressed` - Fired when alert button is tapped
  - `int $index` - Button index (0-based)
  - `string $label` - Button label text
