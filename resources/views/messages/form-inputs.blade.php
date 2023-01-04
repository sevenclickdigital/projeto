@php $editing = isset($message) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="text" label="Text" maxlength="255" required
            >{{ old('text', ($editing ? $message->text : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="read"
            label="Read"
            :checked="old('read', ($editing ? $message->read : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="message_key"
            label="Message Key"
            maxlength="255"
            required
            >{{ old('message_key', ($editing ? $message->message_key : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="sender" label="Sender">
            @php $selected = old('sender', ($editing ? $message->sender : '')) @endphp
            <option value="user" {{ $selected == 'user' ? 'selected' : '' }} >User</option>
            <option value="company" {{ $selected == 'company' ? 'selected' : '' }} >Company</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="sender_id"
            label="Sender Id"
            :value="old('sender_id', ($editing ? $message->sender_id : ''))"
            maxlength="255"
            placeholder="Sender Id"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="receiver_id"
            label="Receiver Id"
            :value="old('receiver_id', ($editing ? $message->receiver_id : ''))"
            maxlength="255"
            placeholder="Receiver Id"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $message->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
