<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\AddressesContact\AddressesContactResponseData;
use App\DataTransferObjects\AddressesContact\AddressesContactsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressesContactRequest;
use App\Models\AddressesContact;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressesContactController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $addressesContacts = AddressesContact::paginate();

        return new ResponsePaginationData([
            'paginator' => $addressesContacts,
            'collection' => new AddressesContactsCollection(['collection' => $addressesContacts->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return AddressesContactResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): NotFoundHttpException|AddressesContactResponseData
    {
        try {
            $addressesContact = AddressesContact::findOrFail($id);
            return new AddressesContactResponseData(['addressesContact' => $addressesContact, 'message' => 'Контактные данные адреса #' . $id . ' успешно получены']);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param AddressesContactRequest $request
     * @return AddressesContactResponseData
     * @throws UnknownProperties
     */
    public function create(AddressesContactRequest $request): AddressesContactResponseData
    {
        $addressesContact = AddressesContact::create($request->all());
        $addressesContact = AddressesContact::find($addressesContact->id);

        return new AddressesContactResponseData(['addressesContact' => $addressesContact, 'message' => 'Контактные данные адреса успешно созданы']);
    }

    /**
     * @param AddressesContactRequest $request
     * @param int $id
     * @return AddressesContactResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(AddressesContactRequest $request, int $id): NotFoundHttpException|AddressesContactResponseData
    {
        try {
            $addressesContact = AddressesContact::findOrFail($id);
            $addressesContact->address_id = $request->address_id ?? $addressesContact->address_id;
            $addressesContact->type = $request->type ?? $addressesContact->type;
            $addressesContact->value = $request->value ?? $addressesContact->value;
            $addressesContact->save();

            return new AddressesContactResponseData(['addressesContact' => $addressesContact, 'message' => 'Контактные данные адреса успешно обновлены']);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function delete(int $id): NotFoundHttpException|JsonResponse
    {
        try {
            AddressesContact::findOrFail($id)->delete();

            return $this->responseSuccess('Контактные данные адреса успешно удалены');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return NotFoundHttpException|JsonResponse
     */
    public function restore(int $id): NotFoundHttpException|JsonResponse
    {
        try {
            AddressesContact::withTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess('Контактные данные адреса успешно восстановлены');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
