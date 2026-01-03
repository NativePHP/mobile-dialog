# Dialog Plugin for NativePHP Mobile

Native alert dialogs and toast notifications for NativePHP Mobile applications.

## Overview

The Dialog API provides cross-platform native alert dialogs and toast/snackbar notifications.

## Installation

```bash
composer require nativephp/mobile-dialog
```

## Usage

### Alert Dialogs

#### PHP (Livewire/Blade)

```php
use Native\Mobile\Facades\Dialog;
use Native\Mobile\Events\Alert\ButtonPressed;

// Simple alert
Dialog::alert('Hello', 'Welcome to our app!');

// Alert with custom buttons
Dialog::alert('Confirm', 'Are you sure?', ['Cancel', 'Delete'])
    ->id('delete-confirm')
    ->show();

// Listen for button press
#[OnNative(ButtonPressed::class)]
public function handleButton($index, $label, $id = null)
{
    if ($id === 'delete-confirm' && $label === 'Delete') {
        $this->deleteItem();
    }
}
```

#### JavaScript (Vue/React/Inertia)

```js
import { dialog, on, off, Events } from '#nativephp';

// Simple alert
await dialog.alert('Hello', 'Welcome to our app!');

// Alert with custom buttons
await dialog.alert('Confirm', 'Are you sure?', ['Cancel', 'Delete'])
    .id('delete-confirm');

// Listen for button press
const handleButton = (payload) => {
    const { index, label, id } = payload;
    if (id === 'delete-confirm' && label === 'Delete') {
        deleteItem();
    }
};

on(Events.Alert.ButtonPressed, handleButton);
```

### Toast Notifications

#### PHP

```php
use Native\Mobile\Facades\Dialog;

// Short toast (2 seconds)
Dialog::toast('Item saved!', 'short');

// Long toast (4 seconds) - default
Dialog::toast('Processing complete');
```

#### JavaScript

```js
import { dialog } from '#nativephp';

// Short toast
dialog.toast('Item saved!', 'short');

// Long toast (default)
dialog.toast('Processing complete');
```

## Configuration Methods

### Alert Methods

#### `id(string $id)`

Set a unique identifier for the alert. Useful for identifying which alert triggered a button press.

```php
Dialog::alert('Title', 'Message', ['OK', 'Cancel'])
    ->id('my-alert');
```

#### `event(string $eventClass)`

Specify a custom event class to dispatch when a button is pressed.

```php
Dialog::alert('Title', 'Message')
    ->event(MyCustomEvent::class);
```

#### `remember()`

Store the alert ID in session for retrieval in event handlers.

```php
Dialog::alert('Title', 'Message')
    ->id('confirm-action')
    ->remember();

// Later, in event handler
$alertId = \Native\Mobile\PendingAlert::lastId();
```

#### `show()`

Explicitly display the alert. If not called, the alert shows automatically when the object is destructed.

```php
Dialog::alert('Title', 'Message')->show();
```

### Toast Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `message` | string | required | The message to display |
| `duration` | string | `'long'` | `'short'` (2s) or `'long'` (4s) |

## Events

### `ButtonPressed`

Fired when a button in an alert dialog is tapped.

**Properties:**
- `int $index` - The button index (0-based)
- `string $label` - The button label text
- `string|null $id` - The alert ID (if set)

#### PHP

```php
use Native\Mobile\Attributes\OnNative;
use Native\Mobile\Events\Alert\ButtonPressed;

#[OnNative(ButtonPressed::class)]
public function handleButton($index, $label, $id = null)
{
    match($label) {
        'Delete' => $this->delete(),
        'Cancel' => null,
        default => null,
    };
}
```

#### Vue

```js
import { on, off, Events } from '#nativephp';
import { onMounted, onUnmounted } from 'vue';

const handleButton = (payload) => {
    const { index, label, id } = payload;
    if (label === 'Delete') {
        deleteItem();
    }
};

onMounted(() => on(Events.Alert.ButtonPressed, handleButton));
onUnmounted(() => off(Events.Alert.ButtonPressed, handleButton));
```

## Platform Behavior

### Alert Dialogs
- **Android:** Native `AlertDialog` via `NativeActionCoordinator`
- **iOS:** Native `UIAlertController` with `.alert` style

### Toast Notifications
- **Android:** Material Design `Snackbar` (positioned above bottom navigation)
- **iOS:** Custom `ToastManager` overlay

## License

MIT