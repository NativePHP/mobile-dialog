## nativephp/dialog

Native alert dialogs and toast notifications for NativePHP Mobile applications.

### Installation

```bash
composer require nativephp/dialog
php artisan native:plugin:register nativephp/dialog
```

### PHP Usage (Livewire/Blade)

Use the `Dialog` facade:

@verbatim
<code-snippet name="Alert Dialogs" lang="php">
use Native\Mobile\Facades\Dialog;

// Simple alert
Dialog::alert('Hello', 'Welcome to our app!');

// Alert with custom buttons
Dialog::alert('Confirm', 'Are you sure?', ['Cancel', 'Delete'])
    ->id('delete-confirm')
    ->show();

// With custom event class
Dialog::alert('Title', 'Message')
    ->event(MyCustomEvent::class);
</code-snippet>
@endverbatim

@verbatim
<code-snippet name="Toast Notifications" lang="php">
use Native\Mobile\Facades\Dialog;

// Short toast (2 seconds)
Dialog::toast('Item saved!', 'short');

// Long toast (4 seconds) - default
Dialog::toast('Processing complete');
</code-snippet>
@endverbatim

### Handling Alert Events

@verbatim
<code-snippet name="Listening for Button Press" lang="php">
use Native\Mobile\Attributes\OnNative;
use Native\Mobile\Events\Alert\ButtonPressed;

#[OnNative(ButtonPressed::class)]
public function handleButton($index, $label, $id = null)
{
    if ($id === 'delete-confirm' && $label === 'Delete') {
        $this->deleteItem();
    }
}
</code-snippet>
@endverbatim

### JavaScript Usage

@verbatim
<code-snippet name="Dialogs in JavaScript" lang="js">
import { dialog, on, off, Events } from '#nativephp';

// Simple alert
await dialog.alert('Hello', 'Welcome to our app!');

// Alert with custom buttons
await dialog.alert('Confirm', 'Are you sure?', ['Cancel', 'Delete'])
    .id('delete-confirm');

// Toast notifications
dialog.toast('Item saved!', 'short');
dialog.toast('Processing complete');

// Listen for button press
const handleButton = (payload) => {
    const { index, label, id } = payload;
    if (id === 'delete-confirm' && label === 'Delete') {
        deleteItem();
    }
};

on(Events.Alert.ButtonPressed, handleButton);
</code-snippet>
@endverbatim

### Available Methods

#### Alert Methods

- `Dialog::alert(string $title, string $message, array $buttons = ['OK'])` - Show alert dialog
- `->id(string $id)` - Set unique identifier for tracking
- `->event(string $class)` - Set custom event class
- `->remember()` - Store ID in session for retrieval
- `->show()` - Explicitly display the alert

#### Toast Methods

- `Dialog::toast(string $message, string $duration = 'long')` - Show toast notification
  - `'short'` - 2 seconds
  - `'long'` - 4 seconds (default)

### Events

- `Native\Mobile\Events\Alert\ButtonPressed` - Fired when alert button is tapped
  - `int $index` - Button index (0-based)
  - `string $label` - Button label text
  - `string|null $id` - Alert ID if set

### Platform Details

- **Android Alerts**: Native `AlertDialog` via `NativeActionCoordinator`
- **iOS Alerts**: Native `UIAlertController` with `.alert` style
- **Android Toasts**: Material Design `Snackbar` (positioned above bottom navigation)
- **iOS Toasts**: Custom `ToastManager` overlay
